<?php

class FoodDescription extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'food_des';

	/**
	 * Primary Key
	 * @var string
	 */
	protected $primaryKey = 'ndb_no';

	public static function searchAutocomplete($query, $first = false) {
//		return self::where('long_desc', 'ilike', '%'.$query.'%')->get();
		$des = new FoodDescription();
		$grp = new FoodGroupDescription();

        $dbQuery = DB::table($des->table)
            ->join($grp->getTable(), $des->table.'.fdgrp_cd', '=', $grp->getTable().'.fdgrp_cd')
            ->select('long_desc as label', 'ndb_no as value', 'fdgrp_desc as optgroup')
            ->where(function($where) use($query) {
                $parts = preg_split('/\s+/', $query);
                foreach($parts as $part) {
                    $where->where('long_desc', 'ilike', '%'.$part.'%');
                }
            })
            ->orderBy( $des->table.'.fdgrp_cd');

        return $first ? $dbQuery->first() : $dbQuery->get();
	}
}
