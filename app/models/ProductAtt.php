<?php
class ProductAtt extends Eloquent
{
    public $table="product_atts";


    public function productRef(){
    	return $this->hasMany('ProductRef', 'product_id');
    }

    public function inspectionDetail(){
        return $this->hasMany('InspectionDetail', 'product_att_id');
    }

    public static function check_product_att_exist($product_att_name) {
        if (ProductAtt::where('name', '=', $product_att_name)->count()>0) {
            return true;
        } else return false;
    }

    public function isValid()
    {
        return Validator::make(
            $this->toArray(),
            array(
				"name"     => "required|unique:product_atts",
				"order_no" => "required|integer"
            )
        )->passes();
    }

}