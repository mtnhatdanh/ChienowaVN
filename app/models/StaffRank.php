<?php
class StaffRank extends Eloquent
{
    public $table="staff_ranks";

    /**
     * One to many relationship
     * @return Object [description]
     */
    public function user(){
    	return $this->belongsTo("User","user_id");
    }

    public static function checkStaffRankExist($user_id){
    	$check = StaffRank::where("user_id", "=", $user_id)->count();
    	if ($check>0) {
    		return true;
    	} else return false;
    }

    /**
     * StaffRank isValid function
     * @return boolean
     */
    public function isValid(){
    	return Validator::make(
    		$this->toArray(), 
    		array(
                'user_id'    =>'required|integer'
    			)
    	)->passes();
    }

}
