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

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });

$router->get('authors', ['as' => 'authors.index', 'uses' => 'AuthorController@index']);
$router->post('authors', ['as' => 'authors.store', 'uses' => 'AuthorController@store']);
$router->get('authors/{author}', ['as' => 'authors.show', 'uses' => 'AuthorController@show']);
$router->put('authors/{author}', ['as' => 'authors.update', 'uses' => 'AuthorController@update']);
$router->delete('authors/{author}', ['as' => 'authors.destroy', 'uses' => 'AuthorController@destroy']);