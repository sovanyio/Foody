<?php

class DataSource extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'data_src';

	/**
	 * Primary Key
	 * @var string
	 */
	protected $primaryKey = 'datasrc_id';

}
