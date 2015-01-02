<?php

class NutrientDefinition extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'nutr_def';

	/**
	 * Primary Key
	 * @var string
	 */
	protected $primaryKey = 'nutr_no';

	public function getTable() {
		return $this->table;
	}
}
