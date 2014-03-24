<?php
class Equipment extends Eloquent
{
    public $table="measuring_equipments";

    public function calibration(){
    	return $this->hasMany("Calibration","equipment_id");
    }


}