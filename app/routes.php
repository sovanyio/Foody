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

Route::get('/', [
    'as' => 'home',
    function() {
        return View::make('hello')->withTitle('');
    }
]);

Route::post('ingredient-search', [
    'as' => 'ingredientSearch',
	'uses' => 'IngredientController@postSearch'
]);
Route::get('ingredient-detail', [
    'as' => 'ingredient-detail',
	'uses' => 'IngredientController@getIndex'
]);
Route::post('ingredient-detail', [
    'as' => 'ingredientDetail',
    'uses' => 'IngredientController@getDetails'
]);

Route::get('recipe', [
    'as' => 'recipe',
    'uses' => 'RecipeController@getParser'
]);
Route::post('recipe', [
    'as' => 'recipe-submit',
    'uses' => 'RecipeController@postRecipe'
]);