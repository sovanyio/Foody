<?php

class FoodGroupDescription extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'fdgrp_cd';

	/**
	 * Primary Key
	 * @var string
	 */
	protected $primaryKey = 'fdgrp_cd';

	public function getTable() {
		return $this->table;
	}

}
