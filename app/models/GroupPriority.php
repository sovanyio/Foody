<?php

class GroupPriority extends Eloquent {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'group_priorities';

    /**
     * Turn off timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    public function getTable() {
        return $this->table;
    }
}
