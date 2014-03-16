<?php
class MeasuringEquipment extends Eloquent
{
    public $table="measuring_equipments";

    public static function check_equipment_exist($equipment_name) {
    	if (MeasuringEquipment::where('name', '=', $equipment_name)->count()>0) {
    		return true;
    	} else return false;
    }

}