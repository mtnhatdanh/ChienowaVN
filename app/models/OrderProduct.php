<?php
use LaravelBook\Ardent\Ardent;
class OrderProduct extends Ardent
{
    public $table="or_products";

    public static $rules = array(
        'name'     =>'required|min:3'
        );

    public static $relationsData = array(
        'orderDetails' => array(self::HAS_MANY, 'OrderDetail', 'order_product_id')
        ); 

    public static function check_order_product_exist($product_name) {
        if (OrderProduct::where('name', '=', $product_name)->count()>0) {
            return true;
        } else return false;
    }

}
