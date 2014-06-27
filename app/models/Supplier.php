<?php
use LaravelBook\Ardent\Ardent;
class Supplier extends Ardent
{
    public $table="suppliers";

    public static $rules = array(
        'name'  =>'required|unique:suppliers',
        'email' =>'email'
        );

    public static $relationsData = array(
        'quotations' => array(self::HAS_MANY, 'Quotation', 'supplier_id'),
        'orders'     => array(self::HAS_MANY, 'Order', 'supplier_id')
        );
        
    public static function checkSupplierExist($supplier_name){
        if (Supplier::where('name', '=', $supplier_name)->count()>0) {
            return true;
        } else return false;
    }

}
