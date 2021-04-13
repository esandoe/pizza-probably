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

$router->get('/', 'HomeController@show');

$router->get('/recipe/{id}', 'RecipeController@show');
$router->get('/edit/{id}', 'RecipeController@edit');
$router->post('/edit/{id}', 'RecipeController@update');

$router->post('/edit/{id}/images', 'UploadController@uploadImage');
$router->delete('/edit/{id}/images', 'UploadController@deleteImage');

