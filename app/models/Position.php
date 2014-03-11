<?php
class Position extends Eloquent
{
    public $table="positions";

    public function user(){
    	return $this->hasMany("User","position_id");
    }
}
