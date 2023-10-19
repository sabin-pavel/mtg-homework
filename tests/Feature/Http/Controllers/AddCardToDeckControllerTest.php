<?php

use App\Models\Card;
use App\Models\Deck;
use Illuminate\Support\Facades\Cache;
use mtgsdk\Card as MtgCard;

it('can add card (from DB) to deck', function () {
    /** @var Deck $deck */
    $deck = Deck::factory()->createOne();
    /** @var Card $card */
    $card = Card::factory()->createOne();

    $response = $this->post("/deck/{$deck->id}/add-card", ['card_uuid' => $card->uuid]);

    $response->seeJson($card->toArray());

    $this->seeInDatabase('decks_cards', [
        'deck_id' => $deck->id,
        'card_uuid' => $card->uuid,
    ]);
})
    ->group('Decks', 'Cards');


it('can add card (from cache) to deck', function () {
    /** @var Deck $deck */
    $deck = Deck::factory()->createOne();
    /** @var Card $card */
    $card = Card::factory()->makeOne();

    Cache::shouldReceive('get')
        ->once()
        ->with($card->uuid)
        ->andReturn(new MtgCard(array_merge($card->toArray(), ['id' => $card->uuid])));

    $response = $this->post("/deck/{$deck->id}/add-card", ['card_uuid' => $card->uuid]);

    $response->seeJson($card->toArray());

    $this->seeInDatabase('decks_cards', [
        'deck_id' => $deck->id,
        'card_uuid' => $card->uuid,
    ]);
})
    ->group('Decks', 'Cards');


it('throws validation error when trying to add card multiple times to same deck', function () {
    /** @var Deck $deck */
    $deck = Deck::factory()->createOne();
    /** @var Card $card */
    $card = Card::factory()->createOne();

    $card->decks()->attach($deck->id);

    $response = $this->post("/deck/{$deck->id}/add-card", ['card_uuid' => $card->uuid]);

    $response->seeJson(["card_uuid" => ["Your deck already has this card"]]);
})
    ->group('Decks', 'Cards');



it('throws validation error when trying to exceed card limit in one deck', function () {
    /** @var Deck $deck */
    $deck = Deck::factory()->createOne();
    /** @var Card $card */
    $cards = Card::factory()->createMany(Deck::MAX_NUMBER_OF_CARDS_PER_DECK);

    $deck->cards()->attach($cards->pluck('uuid'));

    $card = Card::factory()->createOne();

    $response = $this->post("/deck/{$deck->id}/add-card", ['card_uuid' => $card->uuid]);

    $response->seeJson(["deck_uuid" => ["The maximum number of cards in this deck was already reached."]]);
})
    ->group('Decks', 'Cards');
