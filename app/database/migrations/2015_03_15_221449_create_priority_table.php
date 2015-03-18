<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriorityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::transaction(function() {
            Schema::create('group_priorities', function(Blueprint $tbl) {
                $tbl->increments('id');
                $tbl->string('fdgrp_cd');
                $tbl->integer('priority');
            });
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::transaction(function() {
            Schema::drop('group_priorities');
        });
	}

}
