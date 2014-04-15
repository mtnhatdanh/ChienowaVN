<?php
use LaravelBook\Ardent\Ardent;
class StaffRank extends Ardent
{
    public $table="staff_ranks";

    public static $rules = array('user_id'=>'required|integer');

    public static $relationsData = array(
        'user' => array(self::BELONGS_TO, 'User', 'user_id')
        ); 

    public static function checkStaffRankExist($user_id){
    	$check = StaffRank::where("user_id", "=", $user_id)->count();
    	if ($check>0) {
    		return true;
    	} else return false;
    }

}
