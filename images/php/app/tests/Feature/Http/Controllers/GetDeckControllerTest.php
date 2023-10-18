<?php

use App\Enums\Types;
use App\Models\Card;
use App\Models\Deck;

it('can retrieve deck', function ($requestParams) {
    $deck = Deck::factory()->createOne($requestParams);

    $response = $this->get("/deck/{$deck->id}");

    $responseProperties = [
        'name' => $requestParams['name'],
        'average_cmc' => 0,
    ];

    if (isset($requestParams['description'])) {
        $responseProperties['description'] = $requestParams['description'];
    }

    $response->seeJson($responseProperties);
})
    ->group('Decks')
    ->with('createDeck_with_valid_params');

it('can calculate average cmc', function ($requestParams) {
    /** @var Deck $deck */
    $deck = Deck::factory()->createOne($requestParams);

    $cards = Card::factory()->createMany(15);
    $deck->cards()->attach($cards->pluck('uuid'));

    /** @var Card $card */
    $cmcSum = 0;
    $cardsCountExcludingLandType = 0;
    foreach ($cards as $card) {
        if ($card->types[0] != Types::LAND) {
            $cmcSum += $card->cmc;
            $cardsCountExcludingLandType++;
        }
    }

    $response = $this->get("/deck/{$deck->id}");

    $responseProperties = [
        'name' => $requestParams['name'],
        'average_cmc' => round($cmcSum / $cardsCountExcludingLandType,2),
    ];

    if (isset($requestParams['description'])) {
        $responseProperties['description'] = $requestParams['description'];
    }

    $response->seeJson($responseProperties);
})
    ->group('Decks')
    ->with('createDeck_with_valid_params');


it('throws validation error when deck uuid does not exist in local database', function () {
    $response = $this->get("/deck/5770c63e-2ee9-4df4-b44d-a58a38e85b93");

    $response->seeJson(['deck_uuid' => ['The selected deck uuid is invalid.']]);
})
    ->group('Decks');


it('throws validation error when deck is not a valid uuid', function () {
    $response = $this->get("/deck/5770c63e");

    $response->seeJson(['deck_uuid' => ['The deck uuid must be a valid UUID.']]);
})
    ->group('Decks');
