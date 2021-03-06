<?php
use LaravelBook\Ardent\Ardent;
class Order extends Ardent
{
    public $table="orders";

    public static $rules = array(
        'user_id'       =>'required|integer',
        'date'          =>'required|date',
        'supplier_id'   =>'required|integer',
        'due_date'      =>'required|date'
        );

    public static $relationsData = array(
        'user'         => array(self::BELONGS_TO, 'User', 'user_id'),
        'supplier'     => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
        'orderDetails' => array(self::HAS_MANY, 'OrderDetail', 'order_id')
        ); 

}
