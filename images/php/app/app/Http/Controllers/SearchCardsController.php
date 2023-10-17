<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use DateInterval;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller;
use mtgsdk\Card;
use Symfony\Component\HttpFoundation\Response;

class SearchCardsController extends Controller
{
    private array $rules = [
        'name'          => 'string',
        'layout'        => 'string',
        'cmc'           => 'integer',
        'colors'        => 'string',
        'colorIdentity' => 'string',
        'type'          => 'string',
        'supertypes'    => 'string',
        'types'         => 'string',
        'subtypes'      => 'string',
        'rarity'        => 'string',
        'set'           => 'string',
        'setName'       => 'string',
        'text'          => 'string',
        'flavor'        => 'string',
        'artist'        => 'string',
        'number'        => 'string',
        'power'         => 'string',
        'toughness'     => 'string',
        'loyalty'       => 'string',
        'language'      => 'string',
        'gameFormat'    => 'string',
        'legality'      => 'string',
        'page'          => 'integer',
        'pageSize'      => 'integer',
        'orderBy'       => 'string',
        'random'        => 'in:0,1',
        'contains'      => 'string',
        'id'            => 'string',
        'multiverseid'  => 'integer',
    ];

    public function search(Request $request): JsonResponse
    {
        $unknownParams = $this->validateRequestKeys($request);

        if (!empty($unknownParams)) {
            Log::notice(__METHOD__ . ": Unknown parameters.", $unknownParams);

            return $this->buildFailedValidationResponse($request, $unknownParams);
        }

        try {
            $this->validateRequestValues($request);
        } catch (ValidationException $exception) {
            Log::notice(__METHOD__ . ": Validation exception.", [
                'errors' => $exception->validator->errors()->toArray(),
                'request' => $request->toArray(),
            ]);

            return $this->buildFailedValidationResponse($request, $exception->validator->errors()->toArray());
        }

        $filters = $this->parseFilters($request);

        $cardsFromMtg = Cache::get($this->getCacheKey($filters));

        if (!$cardsFromMtg) {
            try {
                Log::debug(__METHOD__ . ": Call MTG API via SDK.", $filters);

                /* MTG SDK */
                $cardsFromMtg = Card::where($filters)->all();

                /* Cache results */
                Cache::set($this->getCacheKey($filters), $cardsFromMtg, DateInterval::createFromDateString('1 day'));
            } catch (Exception $exception) {
                Log::error(__METHOD__ . ": {$exception->getMessage()}");

                return new JsonResponse([$exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        /* Transform array of objects in clean json */
        return new JsonResponse(array_map(fn(Card $card) => ((array)$card)["\x00*\x00data"], $cardsFromMtg));
    }

    private function validateRequestKeys(Request $request): array
    {
        Log::debug(__METHOD__, array_keys($request->toArray()));

        $unknownParams = [];
        foreach ($request->all() as $key => $value) {
            if (!isset($this->rules[$key])) {
                $unknownParams[$key] = "$key is an unknown parameter. Please remove it.";
            }
        }

        return $unknownParams;
    }

    /**
     * @throws ValidationException
     */
    private function validateRequestValues(Request $request): void
    {
        Log::debug(__METHOD__, $request->toArray());

        $this->validate($request, $this->rules, [
            'random' => 'The selected random is invalid. Please use one of the following: [0, 1]'
        ]);
    }

    private function parseFilters(Request $request): array
    {
        Log::debug(__METHOD__);

        $filters = [
            'page'     => $request->get('page', 1),
            'pageSize' => $request->get('random') ? rand(1, 100) : $request->get('pageSize', 100),
        ];

        return array_merge($request->toArray(), $filters);
    }

    private function getCacheKey(array $searchParams): string
    {
        /* Prepare  */
        unset($searchParams['random']);
        ksort($searchParams);

        return http_build_query($searchParams);
    }
}
