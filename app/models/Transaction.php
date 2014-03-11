<?php
class Transaction extends Eloquent
{
    public $table="transactions";

    public function item(){
    	return $this->belongsTo("Item","item_id");
    }


}