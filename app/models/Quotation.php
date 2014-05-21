<?php
use LaravelBook\Ardent\Ardent;
class Quotation extends Ardent
{
    public $table="quotation";

    public static $rules = array(
        'user_id'     =>'required|integer',
        'date'        =>'required|date',
        'supplier_id' =>'required|integer',
        'product'     =>'required',
        'due_date'    =>'required|date',
        );

    public static $relationsData = array(
        'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        'supplier'=>array(self::BELONGS_TO, 'Supplier', 'supplier_id')
        ); 

}
