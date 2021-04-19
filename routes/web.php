<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/articulos', 'ArticuloController@index');
$router->post('/articulos', 'ArticuloController@save');
$router->get('/articulos/{id}', 'ArticuloController@viewById');
$router->delete('/articulos/{id}', 'ArticuloController@delete');
$router->post('/articulos/{id}', 'ArticuloController@update');
