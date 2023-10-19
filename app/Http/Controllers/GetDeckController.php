<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Deck;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller;

class GetDeckController extends Controller
{
    private array $rules = [
        'deck_uuid' => 'required|uuid|exists:decks,id',
    ];

    public function get(Request $request, string $deckUuid): JsonResponse
    {
        try {
            $this->validateRequestValues($deckUuid);
        } catch (ValidationException $exception) {
            Log::notice(__METHOD__ . ": Validation exception.", [
                'errors'  => $exception->validator->errors()->toArray(),
                'request' => ['deck_uuid' => $deckUuid],
            ]);

            return $this->buildFailedValidationResponse($request, $exception->validator->errors()->toArray());
        }

        $deck = Deck::find($deckUuid);

        return new JsonResponse($deck->toArray());
    }

    /**
     * @throws ValidationException
     */
    private function validateRequestValues(string $deckUuid): void
    {
        Log::debug(__METHOD__, ['deck_uuid' => $deckUuid]);

        $validator = Validator::make(
            ['deck_uuid' => $deckUuid],
            $this->rules,
        );

        $validator->validate();
    }
}
