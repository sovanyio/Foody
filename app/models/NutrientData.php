<?php

class NutrientData extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'nut_data';

	public static function retrieveByFood(FoodDescription $food) {
		$nutrient = new NutrientData();
		$nutDef   = new NutrientDefinition();
		$src      = new SourceCode();
		
		return DB::table($nutrient->table)
			->join($nutDef->getTable(), $nutrient->table.'.nutr_no', '=', $nutDef->getTable().'.nutr_no')
			->leftJoin($src->getTable(), $nutrient->table.'.src_cd', '=', $src->getTable().'.src_cd')
			->select('nutrdesc as name', 'nutr_val as value', 'units', 'srccd_desc as help_text')
			->where('ndb_no', '=', $food->ndb_no)
			->where($nutDef->getTable().'.nutr_no', '<>', '268') // Exclude kJ
			->orderBy('sr_order')
			->get();
	}

}
