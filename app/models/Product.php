<?php
class Product extends Eloquent
{
    public $table="products";

    public function calibration(){
    	return $this->hasMany("Report","product_id");
    }


}