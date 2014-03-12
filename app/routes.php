<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});


Route::get('signin', function(){
	if (Session::has('error_signin')) {
		$error = Session::get('error_signin');
		return View::make('signin',array('error'=>$error));
	} else return View::make('signin');
});

Route::post('signin', function() {
	if (User::check_signin(Input::get('username'), md5(sha1(Input::get('password'))))) {
		$user = User::where('username', '=', Input::get('username'))->get()->first();
		Session::put('user', $user);
		return Redirect::to('/user/manage-user');
	} else {
		$error = "** Wrong username or password **";
		Session::put('error_signin', $error);
		return Redirect::to('signin');
	}
});

Route::filter('check_signin', function(){
	if(!Session::has('user')) {
		return Redirect::to('signin');
	}
});

//Main route
Route::group(array('before'=>'check_signin'), function(){
	Route::controller('user', 'UserController');
	Route::controller('attribute', 'AttributeController');
	Route::controller('category', 'CategoryController');
	Route::controller('item', 'ItemController');
	Route::controller('inventory', 'InventoryController');
	Route::controller('report', 'ReportController');
	Route::controller('expense', 'ExpenseController');
});

//Check for validation jquery
Route::group(array("prefix"=>"check"), function(){
	Route::post('check-username', function(){
		if (User::check_username(Input::get('username'))) {
			return "true";
		} else return "false";
	});
	Route::post('check-email', function(){
		if (User::check_email(Input::get('email'))) {
			return "true";
		} else return "false";
	});
	Route::post('check-attribute', function(){
		if (Attribute::check_attribute(Input::get('name'))) {
			return "true";
		} else return "false";
	});
	Route::post('check-item-id', function(){
		if(Item::checkIdExist(Input::get('item_id'))) {
			return "true";
		} else return "false";
	});
	Route::post('check-item-name', function(){
		if(ItemAtt::checkValueExist(Input::get('item'))) {
			return "true";
		} else return "false";
	});
});

//Get data to lookup

Route::group(array("prefix"=>"data"), function(){
	
	Route::post('amount-inStock', function(){
		$item_id = Input::get('item_id');
		$sumTransactions = Item::getInStock($item_id);
		echo $sumTransactions['inStock'];
	});
	
	// Ajax for Info Item Button
	Route::post('item-info', function(){
		$item_id = Input::get('item_id');
		$itematts = ItemAtt::join('attributes', 'attributes.id', '=', 'item_atts.attribute_id')
				->orderBy('order_no', 'asc')
				->where('item_id', '=', $item_id)
				->get();
		return View::make('item_info', array('itematts'=>$itematts, 'item_id'=>$item_id));
	});

	// Ajax for Trans Button
	Route::post('transaction-byday', function(){
		$item_id  = Input::get('item_id');
		$from_day = Input::get('from_day');
		$to_day   = Input::get('to_day');
		$transactions = Transaction::where('item_id', '=', $item_id)
						->whereBetween('date', array($from_day, $to_day))
						->get();
		$item = Item::find($item_id);
		$data = array(
			'item'         => $item,
			'transactions' => $transactions,
			'from_date'    => $from_day,
			'to_day'       => $to_day
			);
		return View::make('Report_View.item_trans_ajax', $data);
	});

});

Route::get('test', function(){
	$result = DB::table('information_schema.tables')
			->select('auto_increment')
			->where('table_schema', '=', 'ChienowaVN')
			->where('table_name', '=', 'users')
			->first();
	print_r($result);
	// dd(DB::getQueryLog());
});

