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

	public function getIndex($passedData = null)
	{
		$groups  = FoodGroupDescription::all();

		$opts = [];
		foreach($groups as $key => $group) {
			$opts[$group->fdgrp_desc] = [];
		}

        $data = [
            'title' => 'Ingredient Search',
            'optgroups' => $opts
        ];

		if($passedData) {
            $data['ingredient'] = $passedData['one']['ingredient'] ?: null;
            $data['compare'] = $passedData['two']['ingredient'] ?: null;

			return View::make('ingredients.search', $data)
                ->nest('detail', 'ingredients.details', $passedData['one'] ?: [])
                ->nest('compareDetails', 'ingredients.details', $passedData['two'] ?: []);
		}
		return View::make('ingredients.search', $data);
	}

	public function postDetails($return = false) {
		$ingredient = FoodDescription::where('ndb_no', '=', $return ?: Input::get('ingredient'))->first();

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
        $index = count(Input::all());

        if (!$index) {
            return $this->getIndex();
        }
		return $this->getIndex(
			[
                'one' => $this->postDetails(Input::get('ingredient', false)),
                'two' => $this->postDetails(Input::get('compare', false))
            ]
		);
	}

	public function postSearch() {
		$query = Input::get('ingredient');

		echo json_encode(FoodDescription::searchAutocomplete($query));
	}

}
