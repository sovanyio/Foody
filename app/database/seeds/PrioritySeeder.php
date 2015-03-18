<?php

class PrioritySeeder extends Seeder {

    private $items = [
        [ 'fdgrp_cd' => '0100', 'priority' => 10 ],
        [ 'fdgrp_cd' => '0200', 'priority' => 10 ],
        [ 'fdgrp_cd' => '0300', 'priority' => 20 ],
        [ 'fdgrp_cd' => '0400', 'priority' => 10 ],
        [ 'fdgrp_cd' => '0500', 'priority' => 10 ],
        [ 'fdgrp_cd' => '0600', 'priority' => 15 ],
        [ 'fdgrp_cd' => '0700', 'priority' => 20 ],
        [ 'fdgrp_cd' => '0800', 'priority' => 20 ],
        [ 'fdgrp_cd' => '0900', 'priority' => 10 ],
        [ 'fdgrp_cd' => '1000', 'priority' => 10 ],
        [ 'fdgrp_cd' => '1100', 'priority' => 10 ],
        [ 'fdgrp_cd' => '1200', 'priority' => 10 ],
        [ 'fdgrp_cd' => '1300', 'priority' => 10 ],
        [ 'fdgrp_cd' => '1400', 'priority' => 15 ],
        [ 'fdgrp_cd' => '1500', 'priority' => 10 ],
        [ 'fdgrp_cd' => '1600', 'priority' => 15 ],
        [ 'fdgrp_cd' => '1700', 'priority' => 10 ],
        [ 'fdgrp_cd' => '1800', 'priority' => 20 ],
        [ 'fdgrp_cd' => '1900', 'priority' => 20 ],
        [ 'fdgrp_cd' => '2000', 'priority' => 15 ],
        [ 'fdgrp_cd' => '2100', 'priority' => 30 ],
        [ 'fdgrp_cd' => '2200', 'priority' => 30 ],
        [ 'fdgrp_cd' => '2500', 'priority' => 30 ],
        [ 'fdgrp_cd' => '3500', 'priority' => 15 ],
        [ 'fdgrp_cd' => '3600', 'priority' => 30 ]
    ];

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('group_priorities')->delete();

        foreach($this->items as $item) {
            GroupPriority::create($item);
        }
	}

}
