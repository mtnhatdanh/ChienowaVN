<?php
use LaravelBook\Ardent\Ardent;
class Supplier extends Ardent
{
    public $table="suppliers";

    public static $rules = array(
        'name'  =>'required|unique',
        'email' =>'email'
        );

    // public static $relationsData = array(
    //     'user' => array(self::BELONGS_TO, 'User', 'user_id')
    //     ); 
        
    public static function checkSupplierExist($supplier_name){
        if (Supplier::where('name', '=', $supplier_name)->count()>0) {
            return true;
        } else return false;
    }        

}
