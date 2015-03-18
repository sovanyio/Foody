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

    protected static $dropWords = [
        // Size
        'thin',
        'thick',

        // Cut
        'spiral',
        'spirals',
        'spiralized',
        'diced',
        'chopped',
        'minced',
        'julienne',
        'julienned',
        'shreds',
        'shredded',
        'sliced',
        'slices',
        'slice',


        // Modifier
        'fresh',
        'organic',
        'squeezed',
    ];

    public function foodGroupDescription() {
        return $this->hasOne('FoodDescription', 'fdgrp_cd', 'fdgrp_cd');
    }

	public static function searchAutocomplete($query, $first = false) {
        $des = new self();
        $grp = new FoodGroupDescription();
        $pri = new GroupPriority();

        $dbQuery = DB::table($des->table)
            ->join($grp->getTable(), $des->table.'.fdgrp_cd', '=', $grp->getTable().'.fdgrp_cd')
            ->join($pri->getTable(), $grp->getTable().'.fdgrp_cd', '=', $pri->getTable().'.fdgrp_cd')
            ->select('long_desc as label', 'ndb_no as value', 'fdgrp_desc as optgroup')
            ->where(function($where) use($query) {
                $parts = preg_split('/\s+/', $query);
                foreach($parts as $k => $part) {
                    $where->whereRaw("long_desc like '%{$part}%'");
                }
            })
            ->orderBy('priority');

        return $first ? $dbQuery->first() : $dbQuery->get();
	}

    public static function searchIngredients($query) {
        // Clean Query
        foreach(self::$dropWords as $drop) {
            $query = preg_replace('/'.$drop.'/i', '', $query);
        }

        return self::searchAutocomplete(trim($query));
    }
}
