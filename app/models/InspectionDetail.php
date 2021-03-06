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
        // Get global array from config/validInspection.php file
        $validTableA = Config::get('validInspection.validTableA');
        $validTableB = Config::get('validInspection.validTableB');
        
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