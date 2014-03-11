<?php
class Attribute extends Eloquent
{
    public $table="attributes";

    public function reference(){
    	return $this->hasMany("Reference","attribute_id");
    }

    public function itematt(){
    	return $this->hasMany("ItemAtt", "attribute_id");
    }

    /**
     * Check Attribute exists
     * @param  string $name [description]
     * @return login       true or false
     */
    public static function check_attribute($name){
    	$check = Attribute::where("name", "=", $name)->count();
    	if ($check>0) return false;
    	else return true;
    }


}