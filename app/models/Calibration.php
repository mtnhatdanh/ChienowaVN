<?php
class Calibration extends Eloquent
{
    public $table="calibrations";

    public function equipment(){
    	return $this->belongsTo("Equipment","equipment_id");
    }

    public function report(){
        return $this->belongsTo("Report","report_id");
    }

    public function isValid(){
    	return Validator::make(
    		$this->toArray(), 
    		array(
                'report_id'    =>'required|integer',
                'equipment_id' => 'required|integer'
    			)
    	)->passes();
    }


}