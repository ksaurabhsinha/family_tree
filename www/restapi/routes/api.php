<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/v1'], function () use ($router) {
    $router->get('categories', ['uses' => 'CategoryController@getAll']);
    $router->post('categories', ['uses' => 'CategoryController@create']);
    $router->get('categories/{id}', ['uses' => 'CategoryController@getOne']);
    $router->patch('categories/{id}', ['uses' => 'CategoryController@updateVisibility']);
});



