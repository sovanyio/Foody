<?php

class RecipeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function getParser($data = null)
	{
		$groups  = FoodGroupDescription::all();

		$opts = [];
		foreach($groups as $key => $group) {
			$opts[$group->fdgrp_desc] = [];
		}

		if($data) {
			return View::make('ingredients.search', [
				'title'     => 'Ingredient Search',
				'optgroups' => $opts
			])->nest('detail', 'ingredients.details', $data);
		}
		return View::make('ingredients.search', [
			'title'     => 'Ingredient Search',
			'optgroups' => $opts
		]);
	}

}
