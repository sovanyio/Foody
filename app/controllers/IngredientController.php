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

	public function getIndex()
	{
		$groups  = FoodGroupDescription::all();
		$opts = [];
		foreach($groups as $key => $group) {
			$opts[$group->fdgrp_desc] = [];
		}

		return View::make('ingredients.search', [
            'title' => 'Ingredient Search',
            'optgroups' => $opts
        ]);
	}

    public function postSearch() {
        $query = Input::get('ingredient');

        echo json_encode(FoodDescription::searchAutocomplete($query));
    }

	public function getDetails()
    {
		$ingredient = FoodDescription::where('ndb_no', '=', Input::get('ingredient'))->first();
		$data = [
			'ingredient' => $ingredient,
			'details' => $ingredient ? NutrientData::retrieveByFood($ingredient) : null,
			'servings' => $ingredient ? Weight::retrieveByFood($ingredient) : null
		];

        return View::make('ingredients.details', $data);
	}

}
