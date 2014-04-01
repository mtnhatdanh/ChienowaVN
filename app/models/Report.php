<?php
class Report extends Eloquent
{
    public $table="daily_reports";

    public function product(){
    	return $this->belongsTo("Product","product_id");
    }

    public function appStaff(){
        return $this->belongsTo('User', 'app_staff_id');
    }

    public function measurementStaff(){
        return $this->belongsTo('User', 'measurement_staff_id');
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

    public function countEquipment(){
        $result = count($this->calibration);
        return $result;
    }


}