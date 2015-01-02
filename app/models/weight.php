<?php

class Weight extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'weight';


	public static function retrieveByFood(FoodDescription $food) {
		return self::where('ndb_no', '=', $food->ndb_no)
			->orderBy('seq')->get();
	}
}
