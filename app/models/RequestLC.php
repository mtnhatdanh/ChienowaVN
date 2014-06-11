<?php
use LaravelBook\Ardent\Ardent;
class RequestLC extends Ardent
{
    public $table="requests";

    public static $rules = array(
        'user_id'           =>'required|integer',
        'incharge_staff_id' =>'required|integer',
        'date'              =>'required|date',
        'request_content'   =>'required',
        'due_date'          =>'required|date'
        );

    public static $relationsData = array(
        'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        'inchargeStaff' => array(self::BELONGS_TO, 'User', 'incharge_staff_id')
        ); 

}
