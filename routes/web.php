<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/cards', 'SearchCardsController@search');

$router->post('/deck', 'CreateDeckController@create');
$router->post('/deck/{deckUuid}/add-card', 'AddCardToDeckController@add');
$router->get('/deck/{deckUuid}', 'GetDeckController@get');
