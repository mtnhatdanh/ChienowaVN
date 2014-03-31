<?php
class InspectionDetail extends Eloquent
{
    public $table="inspection_details";

    public function inspection(){
    	return $this->belongsTo("Inspection","inspection_id");
    }

    public function productAtt(){
        return $this->belongsTo('ProductAtt', 'product_att_id');
    }

}