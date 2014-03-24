<?php
class Inspection extends Eloquent
{
    public $table="inspections";

    public function report(){
    	return $this->belongsTo("Report","report_id");
    }

    public function user(){
    	return $this->belongsTo("User", "user_id");
    }

    public function isValid()
    {
        return Validator::make(
            $this->toArray(),
            array(
				"report_id" =>"required|integer",
				"user_id"   =>"required|integer",
				"amount"    =>"required|integer",
				"quality"   =>"required"
            )
        )->passes();
    }

}