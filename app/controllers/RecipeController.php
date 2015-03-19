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

	public function getParser()
	{
		return View::make('recipe.parser', [
			'title'     => 'Recipe Estimator',
		]);
	}

    public function postRecipe()
    {
        $ingredients = Input::get('ingredients');
        $out = [];

        foreach($ingredients as $ingredient) {
            if (is_array($ingredient) && !array_key_exists('ingredient', $ingredient)) continue;
            $out[$ingredient['ingredient']] = FoodDescription::searchIngredients($ingredient['ingredient']);
        }

//        foreach($ingredients as $ingredient) {
//            if (!array_key_exists('ingredient', $ingredient)) continue;
//
//            $words = $originalWords = preg_split('/\s/', $ingredient['ingredient']);
//            $result = null;
//
//            // Drop the words LtR to try to find the ingredient
//            while(count($words) > 1 && !$result) {
//                array_shift($words);
//
//                $result = FoodDescription::searchAutocomplete(join(' ', $words), $first = true);
//            }
//
//            if(!$result) {
//                // Drop the words RtL...
//                while(count($originalWords) > 1 && !$result) {
//                    array_pop($originalWords);
//
//                    $result = FoodDescription::searchAutocomplete(join(' ', $words), $first = true);
//                }
//            }
//
//            $out[] = $result ?: null;
//        }

        return $out;
    }

}
