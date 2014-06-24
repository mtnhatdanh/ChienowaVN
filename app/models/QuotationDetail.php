<?php
use LaravelBook\Ardent\Ardent;
class QuotationDetail extends Ardent
{
    public $table="quotation_details";

    public static $rules = array(
        'quotation_id'     =>'required|integer',
        'order_product_id' =>'required|integer'
        );

    public static $relationsData = array(
        'quotation'    => array(self::BELONGS_TO, 'Quotation', 'quotation_id'),
        'orderProduct' => array(self::BELONGS_TO, 'OrderProduct', 'order_product_id')
        ); 

}
