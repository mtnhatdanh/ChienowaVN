<?php
class Product extends Eloquent
{
    public $table="products";

    public function productRef(){
    	return $this->hasMany('ProductRef', 'product_id');
    }

    public function report(){
    	return $this->hasMany("Report","product_id");
    }

	public function isValid()
    {
        return Validator::make(
            $this->toArray(),
            array(
                "name" =>"required|unique:products"
            )
        )->passes();
    }

    public static function check_product_exist($product_name) {
        if (Product::where('name', '=', $product_name)->count()>0) {
            return true;
        } else return false;
    }


}