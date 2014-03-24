<?php
class Report extends Eloquent
{
    public $table="daily_reports";

    public function production(){
    	return $this->belongsTo("Product","product_id");
    }

    public function calibration(){
        return $this->hasMany("Calibration","report_id");
    }

    public function inspection(){
        return $this->hasMany("Inspection","report_id");
    }

    public function isValid()
    {
        return Validator::make(
            $this->toArray(),
            array(
                "product_id" =>"required|integer",
                "date"       =>"required|date"
            )
        )->passes();
    }


}