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

$router->group(['middleware' => 'client.credentials'], function () use ($router) {
    /**
     *  Authors routes
     */
    $router->get('authors', ['as' => 'authors.index', 'uses' => 'AuthorController@index']);
    $router->post('authors', ['as' => 'authors.store', 'uses' => 'AuthorController@store']);
    $router->get('authors/{author}', ['as' => 'authors.show', 'uses' => 'AuthorController@show']);
    $router->put('authors/{author}', ['as' => 'authors.update', 'uses' => 'AuthorController@update']);
    $router->delete('authors/{author}', ['as' => 'authors.destroy', 'uses' => 'AuthorController@destroy']);

    /**
     *  Books routes
     */
    $router->get('books', ['as' => 'books.index', 'uses' => 'BookController@index']);
    $router->post('books', ['as' => 'books.store', 'uses' => 'BookController@store']);
    $router->get('books/{book}', ['as' => 'books.show', 'uses' => 'BookController@show']);
    $router->put('books/{book}', ['as' => 'books.update', 'uses' => 'BookController@update']);
    $router->delete('books/{book}', ['as' => 'books.destroy', 'uses' => 'BookController@destroy']);

    /**
     *  Users routes
     */
    $router->get('users', ['as' => 'users.index', 'uses' => 'UserController@index']);
    $router->post('users', ['as' => 'users.store', 'uses' => 'UserController@store']);
    $router->get('users/{user}', ['as' => 'users.show', 'uses' => 'UserController@show']);
    $router->put('users/{user}', ['as' => 'users.update', 'uses' => 'UserController@update']);
    $router->delete('users/{user}', ['as' => 'users.destroy', 'uses' => 'UserController@destroy']);

   
});


/**
 *  Users /me route
 *  @Middlware auth
 *  @Guard api
 */
$router->group(['middleware' => 'auth:api'], function () use ($router) {
    // $router->get('users/me', ['as' => 'users.me', 'uses' => 'UserController@me']);
});
