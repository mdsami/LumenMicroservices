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

$router->get('books', ['as' => 'books.index', 'uses' => 'BookController@index']);
$router->post('books', ['as' => 'books.store', 'uses' => 'BookController@store']);
$router->get('books/{book}', ['as' => 'books.show', 'uses' => 'BookController@show']);
$router->put('books/{book}', ['as' => 'books.update', 'uses' => 'BookController@update']);
$router->delete('books/{book}', ['as' => 'books.destroy', 'uses' => 'BookController@destroy']);
