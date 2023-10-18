<?php

use App\Models\Card;
use Illuminate\Support\Facades\Cache;
use mtgsdk\Card as MtgCard;

it('can retrieve cards from cache', function ($requestParams) {
    /* Cards are stored in cache exactly as they are retrieved from MTG SDK */
    ksort($requestParams);

    $card1 = Card::factory()->makeOne();
    $card2 = Card::factory()->makeOne();

    Cache::shouldReceive('get')
        ->once()
        ->with(http_build_query($requestParams))
        ->andReturn([
            new MtgCard($card1->toArray()),
            new MtgCard($card2->toArray()),
        ]);

    $response = $this->get('/cards?' . http_build_query($requestParams));

    $response->seeJsonEquals([
        $card1->toArray(),
        $card2->toArray(),
    ]);
})
    ->group('Cards')
    ->with('searchCards_with_valid_params');


it('throws validation error when searching using random other than 0 or 1', function ($requestParams) {
    $response = $this->get('/cards?' . http_build_query($requestParams));

    $response->seeJson(['random' => ['The selected random is invalid. Please use one of the following: [0, 1]']]);
})
    ->group('Cards')
    ->with('searchCards_with_invalid_params');


it('throws validation error when searching using unknown parameters', function ($requestParams) {
    $response = $this->get('/cards?' . http_build_query($requestParams));

    $response->seeJson(['no_worries' => 'no_worries is an unknown parameter. Please remove it.']);
})
    ->group('Cards')
    ->with('searchCards_with_unknown_params');
