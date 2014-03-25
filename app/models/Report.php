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

    public function sumInspection(){
        $sum   = 0;
        $sumOK = 0;
        $sumNG = 0;
        foreach ($this->inspection as $inspection) {
            $sum += $inspection->amount;
            if ($inspection->quality) {
                $sumOK += $inspection->amount;
            } else $sumNG =+ $inspection->amount;
        }
        $result = array('sum'=>$sum, 'sumOK'=>$sumOK, 'sumNG'=>$sumNG);
        return $result;
    }

    public function countEquipment(){
        $result = count($this->calibration);
        return $result;
    }


}