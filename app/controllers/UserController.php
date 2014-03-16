<?php
/**
* UserController Class
*/
class UserController extends Controller
{


	public function __construct(){
		Session::put('active_menu', 'users');
	}
	/**
	 * /user/manage-user
	 * @return View [description]
	 */
	public function getManageUser(){
		$users        = User::where('position_id', '!=', 1)->get();
		$director     = User::where('position_id', '=', 1)->get();
		$notification = Cache::get('notification');
		Cache::forget('notification');
		$data         = array('users'=>$users, 'director'=>$director, 'notification'=>$notification);
		return View::make('User_View.manage',$data);
	}

	/**
	 * Logout funciton
	 * @return void [description]
	 */
	public function getLogout(){
		Session::flush();
		return Redirect::to('signin');
	}

	/**
	 * /user/create-user
	 * @return View [description]
	 */
	public function getCreateUser(){
		return View::make('User_View.create');
	}

	/**
	 * post /user/create-user
	 * @return update [description]
	 */
	public function postCreateUser(){
		$rules = array(
			"name"     =>"required|min:6",
			"username" =>"required|min:3",
			"password" =>"required|min:6",
			"email"    =>"required|email"
			);
		if (!Validator::make(Input::all(), $rules)->fails()) {
			$user              = new User();
			$user->name        = Input::get('name');
			$user->position_id = Input::get('position_id');
			$user->username    = Input::get('username');
			$user->password    = md5(sha1(Input::get('password')));
			$user->mobile      = Input::get('mobile');
			$user->email       = Input::get('email');
			$user->address     = Input::get('address');
			$user->save();
			return Redirect::to('user/manage-user');
		} else echo "Validator fails";
	}

	/**
	 * /user/delete-user
	 * @param  integer $user_id [description]
	 * @return [type]          [description]
	 */
	public function getDeleteUser($user_id){
		User::find($user_id)->delete();
		return Redirect::to('user/manage-user');
	}

	/**
	 * /user/modify-user
	 * @param  integer $user_id User ID
	 * @return [type]          [description]
	 */
	public function getModifyUser($user_id){
		$data = array('user'=> User::find($user_id));
		return View::make('User_View.modify', $data);
	}

	public function postModifyUser($user_id){
		$rules = array(
			"name"     =>"required|min:6",
			"email"    =>"required|email"
			);
		if(Input::get('password')) $rules['password']="required|min:6";
		if (!Validator::make(Input::all(), $rules)->fails()) {
			$user              = User::find($user_id);
			$user->name        = Input::get('name');
			$user->position_id = Input::get('position_id');
			$user->mobile      = Input::get('mobile');
			$user->email       = Input::get('email');
			$user->address     = Input::get('address');
			if(Input::get('password')) $user->password = md5(sha1(Input::get('password')));
			$user->save();
			return Redirect::to('user/manage-user');
		} else echo "Validation fails";

	}
}
