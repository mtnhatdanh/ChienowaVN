<?php
class Expense extends Eloquent
{
    public $table="expenses";

    public function user(){
    	return $this->belongsTo("User","user_id");
    }



}