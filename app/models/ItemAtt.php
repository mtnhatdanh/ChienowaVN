<?php
class ItemAtt extends Eloquent
{
    public $table="item_atts";

    /**
     * One to many relationship
     * @return Object [description]
     */
    public function item(){
    	return $this->belongsTo("Item","item_id");
    }

    public function attribute(){
    	return $this->belongsTo('Attribute', 'attribute_id');
    }

    public static function checkValueExist($value){
        if (ItemAtt::where('value', '=', $value)->count()>0) {
            return true;
        } else return false;
    }   
}