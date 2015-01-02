<?php

class IngredientController extends BaseController {

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

	public function getIndex($data = null)
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

	public function postDetails($return = false) {
		$ingredient = FoodDescription::where('ndb_no', '=', Input::get('ingredient'))->first();
		$data = [
			'ingredient' => $ingredient,
			'details' => $ingredient ? NutrientData::retrieveByFood($ingredient) : null,
			'servings' => $ingredient ? Weight::retrieveByFood($ingredient) : null
		];

		if($return) {
			return $data;
		}

		return View::make('ingredients.details', $data);
	}

	public function getDetails() {
		return $this->getIndex(
			$this->postDetails(true)
		);
	}

	public function postSearch() {
		$query = Input::get('ingredient');

		echo json_encode(FoodDescription::searchAutocomplete($query));
	}

}
