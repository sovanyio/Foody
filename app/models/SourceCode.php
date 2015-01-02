<?php

class SourceCode extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'src_cd';

	/**
	 * Primary Key
	 * @var string
	 */
	protected $primaryKey = 'src_cd';

	public function getTable() {
		return $this->table;
	}
}
