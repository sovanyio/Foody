<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', ['uses' => 'IngredientController@getIndex']);

Route::post('ingredient-search', [
	'uses' => 'IngredientController@postSearch'
]);
Route::post('ingredient-detail', [
	'uses' => 'IngredientController@postDetails'
]);
Route::get('ingredient-detail', [
	'uses' => 'IngredientController@getDetails'
]);