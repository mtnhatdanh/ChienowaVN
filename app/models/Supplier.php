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
        'quotation' => array(self::HAS_MANY, 'Quotation', 'quotation_id')
        ); 
        
    public static function checkSupplierExist($supplier_name){
        if (Supplier::where('name', '=', $supplier_name)->count()>0) {
            return true;
        } else return false;
    }        

}
