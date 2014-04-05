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

    public function equipment(){
    	return $this->belongsTo('Equipment', 'equipment_id');
    }

    public function validWattyProduct(){
        $validTableA = array(
                5 => array('min'=>9.9, 'max'=>10), 
                6 => array('min'=>4.2, 'max'=>4.4),
            );
        $validTableB = array(
                23 => 'OK'
            );
        if (!array_key_exists($this->product_att_id, $validTableA) && !array_key_exists($this->product_att_id, $validTableB)) {
            return true;
        } elseif(array_key_exists($this->product_att_id, $validTableA)) {
            if ($this->value >= $validTableA[$this->product_att_id]['min'] && $this->value <= $validTableA[$this->product_att_id]['max']) {
                return true;
            } else return false;
        } elseif(array_key_exists($this->product_att_id, $validTableB)) {
            if ($this->value == $validTableB[$this->product_att_id]) {
                return true;
            } else return false;
        }
    }

}