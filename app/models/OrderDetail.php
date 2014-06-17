<?php
use LaravelBook\Ardent\Ardent;
class OrderDetail extends Ardent
{
    public $table="order_details";

    public static $rules = array(
        'order_id'         =>'required|integer',
        'price'            =>'required|integer',
        'quantity'         =>'required|integer',
        'order_product_id' =>'required|integer'
        );

    public static $relationsData = array(
        'orderProduct' => array(self::BELONGS_TO, 'OrderProduct', 'order_product_id'),
        'order'        => array(self::BELONGS_TO, 'Order', 'order_id')
        ); 

}
