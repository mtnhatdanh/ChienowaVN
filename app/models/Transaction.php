<?php
class Transaction extends Eloquent
{
    public $table="transactions";

    public function item(){
    	return $this->belongsTo("Item","item_id");
    }

    public function isValid()
    {
        return Validator::make(
            $this->toArray(),
            array(
	            "type"    =>"required|max:1",
				"date"    =>"required|date",
				"item_id" =>"required|integer",
				"amount"  =>"required|numeric"
            )
        )->passes();
    }


}