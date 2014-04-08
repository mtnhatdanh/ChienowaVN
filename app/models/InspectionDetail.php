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
                7 => array('min'=>4.2, 'max'=>4.4),
                8 => array('min'=>19.85, 'max'=>20.15),
                9 => array('min'=>3.4, 'max'=>3.6),
                10 => array('min'=>4, 'max'=>4.1),
                20 => array('min'=>4, 'max'=>4.1),
                22 => array('min'=>4, 'max'=>4.1),
                24 => array('min'=>27, 'max'=>27.15),
                25 => array('min'=>27, 'max'=>27.15),
                26 => array('min'=>27, 'max'=>27.15),
                27 => array('min'=>31.65, 'max'=>31.8),
                28 => array('min'=>31.65, 'max'=>31.8),
                29 => array('min'=>31.65, 'max'=>31.8),
                16 => array('min'=>8.8, 'max'=>9),
                30 => array('min'=>8.8, 'max'=>9),
                31 => array('min'=>8.8, 'max'=>9),
                34 => array('min'=>8.8, 'max'=>9),
                35 => array('min'=>8.8, 'max'=>9),
                36 => array('min'=>8.8, 'max'=>9),
                19 => array('min'=>19.5, 'max'=>20.5),
            );
        $validTableB = array(
                23 => 'OK',
                14 => 'OK',
                15 => 'OK',
                32 => 'OK',
                37 => 'OK'
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