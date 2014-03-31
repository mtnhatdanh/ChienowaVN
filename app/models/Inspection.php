<?php
class Inspection extends Eloquent
{
    public $table="inspections";

    public function report(){
    	return $this->belongsTo("Report","report_id");
    }

    public function inspectionDetail(){
    	return $this->hasMany("InspectionDetail", "inspection_id");
    }

}