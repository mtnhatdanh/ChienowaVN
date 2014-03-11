<?php
class User extends Eloquent
{
    public $table="users";

    /**
     * One to many relationship
     * @return Object [description]
     */
    public function position(){
    	return $this->belongsTo("Position","position_id");
    }

    public static function check_signin($username, $password){
    	$check = User::where("username", "=", $username)->where("password", "=", $password)->count();
    	if ($check>0) return true;
    	else return false;
    }

    /**
     * check username exits
     * @param  [type] $username [description]
     * @return [type]           [description]
     */
    public static function check_username($username) {
    	if (User::where('username', '=', $username)->count()>0) {
    		return false;
    	} else return true;
    }

    /**
     * check email exits
     * @param  [type] $email [description]
     * @return [type]        [description]
     */
    public static function check_email($email) {
    	if (User::where('email', '=', $email)->count()>0) {
    		return false;
    	} else return true;
    }
}
