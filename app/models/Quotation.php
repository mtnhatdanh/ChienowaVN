<?php
use LaravelBook\Ardent\Ardent;
class Quotation extends Ardent
{
    public $table="quotation";

    public static $rules = array(
        'user_id'     =>'required|integer',
        'date'        =>'required|date',
        'supplier_id' =>'required|integer',
        'project_id'  =>'required|integer'
        );

    public static $relationsData = array(
        'user'             => array(self::BELONGS_TO, 'User', 'user_id'),
        'supplier'         => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
        'quotationDetails' => array(self::HAS_MANY, 'QuotationDetail', 'quotation_id'),
        'project'         => array(self::BELONGS_TO, 'Project', 'project_id')
        ); 

}
