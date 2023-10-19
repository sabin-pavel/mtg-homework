<?php

use App\Models\Deck;

it('can create deck', function ($requestParams) {
    $response = $this->post('/deck', $requestParams);

    $responseProperties = ['name' => $requestParams['name']];
    if (isset($requestParams['description'])) {
        $responseProperties['description'] = $requestParams['description'];
    }

    $response->seeJson($responseProperties);

    $this->seeInDatabase('decks', $responseProperties);
})
    ->group('Decks')
    ->with('createDeck_with_valid_params');


it('throws validation error when missing name', function ($requestParams) {
    $response = $this->post('/deck', $requestParams);

    $response->seeJson(['name' => ['The name field is required.']]);
})
    ->group('Decks')
    ->with('createDeck_with_missing_name');


it('throws validation error when name of type other than string', function ($requestParams) {
    $response = $this->post('/deck', $requestParams);

    $response->seeJson(['name' => ['The name must be a string.']]);
})
    ->group('Decks')
    ->with('createDeck_with_invalid_name_type');


it('throws validation error when name is not unique', function ($requestParams) {
    Deck::factory()->createOne($requestParams);

    $response = $this->post('/deck', $requestParams);

    $response->seeJson(['name' => ['The name has already been taken.']]);
})
    ->group('Decks')
    ->with('createDeck_with_valid_params');
