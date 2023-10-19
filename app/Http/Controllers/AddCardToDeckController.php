<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Deck;
use Closure;
use DateInterval;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller;
use mtgsdk\Card as MtgCard;

class AddCardToDeckController extends Controller
{
    private array $rules = [
        'deck_uuid' => 'required|uuid|exists:decks,id',
        'card_uuid' => 'required|uuid',
    ];

    public function add(Request $request, string $deckUuid): JsonResponse
    {
        $cardUuid = $request->get('card_uuid');

        try {
            $this->validateRequestValues($deckUuid, $request);
        } catch (ValidationException $exception) {
            Log::notice(__METHOD__ . ": Validation exception.", [
                'errors'  => $exception->validator->errors()->toArray(),
                'request' => array_merge($request->toArray(), ['deck_uuid' => $deckUuid]),
            ]);

            return $this->buildFailedValidationResponse($request, $exception->validator->errors()->toArray());
        }

        /* search DB for card */
        $card = Card::withUuid($cardUuid)->first();

        if (!$card) {
            /* search cache for card */
            $mtgCard = Cache::get($cardUuid);

            if (!$mtgCard) {
                /* Search MTG for card */
                $mtgCard = MtgCard::find($cardUuid);

                /* Cache card from MTG */
                Cache::set($cardUuid, $mtgCard, DateInterval::createFromDateString('1 day'));
            }

            $cardProperties = ((array)$mtgCard)["\x00*\x00data"];

            $card = Card::create(
                array_merge($cardProperties, [
                    'uuid' => $cardProperties['id'],
                ])
            );
        }

        $card->decks()->attach($deckUuid);

        return new JsonResponse($card->toArray());
    }

    /**
     * @throws ValidationException
     */
    private function validateRequestValues(string $deckUuid, Request $request): void
    {
        $params = [
            'deck_uuid' => $deckUuid,
            'card_uuid' => $request->get('card_uuid'),
        ];

        $validator = Validator::make(
            $params,
            $this->rules,
            ['card_uuid.unique' => 'Your deck already has this card']
        );

        $validator->addRules([
            'deck_uuid' => [
                /* Custom rule to limit number of cards per deck */
                function (string $attribute, string $value, Closure $fail) {
                    $deck = Deck::find($value);

                    if ($deck->cards()->count() >= Deck::MAX_NUMBER_OF_CARDS_PER_DECK) {
                        $fail("The maximum number of cards in this deck was already reached.");
                    }
                },
            ],
            'card_uuid' => [
                /* Custom rule to validate uniqueness for pair (deck_id, card_uuid) */
                Rule::unique('decks_cards')->where(function (Builder $query) use ($params) {
                    return $query->where([
                        'deck_id'   => $params['deck_uuid'],
                        'card_uuid' => $params['card_uuid']
                    ]);
                }),
            ],
        ]);

        Log::debug(__METHOD__, $params);

        $validator->validate();
    }
}
