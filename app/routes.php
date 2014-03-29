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
	return Redirect::to('signin');
});


Route::get('signin', function(){
	if (Session::has('user')) {
		return Redirect::to('/user/manage-user');
	}
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
	Route::controller('quality-control', 'QualityControlController');
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
	// Check valid equipment
	Route::post('check-equiment', function(){
		if(MeasuringEquipment::check_equipment_exist(Input::get('name'))) {
			return "false";
		} else return "true";
	});
	// Check valid product
	Route::post('check-product', function(){
		if(Product::check_product_exist(Input::get('name'))) {
			return "false";
		} else return "true";
	});
	// Check valid product attribute
	Route::post('check-product-attribute', function(){
		if(ProductAtt::check_product_att_exist(Input::get('name'))) {
			return "false";
		} else return "true";
	});
});

//Get data to lookup

Route::group(array("prefix"=>"data"), function(){
	
	Route::post('amount-inStock', function(){
		$item_id = Input::get('item_id');
		$sumTransactions = Item::find($item_id)->getInStock();
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

	// Ajax for Payment From print button
	Route::post('payment-form', function(){
		$expense_id = Input::get('expense_id');
		$expense    = Expense::find($expense_id);
		return View::make('Expense_View.payment_ajax', array('expense'=>$expense));
	});

	// Ajax for Calibration Equipments print button
	Route::post('print-calibrations', function(){
		$date        = Input::get('date');
		$description = Input::get('description');
		$data = array(
			'date'        => $date,
			'description' => $description
			);
		return View::make('Quality_Control_View.calibrations_form_print', $data);
	});

	// Ajax for Daily Quality Control print button
	Route::post('print-quality-report', function(){
		$date        = Input::get('date');
		$description = Input::get('description');
		$product_id  = Input::get('product_id');
		$product     = Product::find($product_id);
		$data = array(
			'date'        => $date,
			'description' => $description,
			'product'     => $product
			);
		return View::make('Quality_Control_View.quality_report_form_print', $data);
	});

});

// Export to Excel
Route::group(array("prefix"=>"excel-export"), function(){
	
	Route::post('inventory-in-stock', function(){
		Excel::loadView('ExportExcel_View.inventory_in_stock')
			->setTitle('Inventory')
			->sheet('InStock')
			->export('xls');
	});

	// Export to excel in Inventory By Day
	Route::post('inventory-by-day', function(){
		$category_id = Input::get('category_id');
		$from_day    = Input::get('from_day');
		$to_day      = Input::get('to_day');

		$items = Item::where('category_id', '=', $category_id)->get();
		$data  = array(
			'items'    =>$items,
			'from_day' =>$from_day,
			'to_day'   =>$to_day
			);
		Excel::loadView('ExportExcel_View.inventory_by_day', $data)
			->setTitle('Inventory_by_day')
			->sheet('ByDay')
			->export('xls');
	});

	// Export to excel in Transaction
	Route::post('transaction', function(){
		$from_day = Input::get('from_day');
		$to_day   = Input::get('to_day');
		$type     = Input::get('transaction_type');
		if ($type == "A") {
			$transactions = Transaction::whereBetween('date', array($from_day, $to_day))->orderBy('date', 'asc')->get();
		} else {
			$transactions = Transaction::whereBetween('date', array($from_day, $to_day))->where('type', '=', $type)->orderBy('date', 'asc')->get();
		}
		$data = array(
			'from_day'     =>$from_day,
			'to_day'       =>$to_day,
			'transactions' =>$transactions
			);
		Excel::loadView('ExportExcel_View.transaction', $data)
			->setTitle('Transaction')
			->sheet('TS')
			->export('xls');
	});

	// Export to excel in Expense
	Route::post('expense', function(){
		$from_day = Input::get('from_day');
		$to_day   = Input::get('to_day');
		$status   = Input::get('status');
		$user_id  = Input::get('user_id');

		$result = Expense::whereBetween('date', array($from_day, $to_day));
		if ($status>=0) {
			$result = $result->where('status', '=', $status);
		}
		if ($user_id>0) {
			$result = $result->where('user_id', '=', $user_id);
		}
		$expenses = $result->orderBy('date', 'asc')->get();

		$data = array(
				'from_day'  =>$from_day,
				'to_day'    =>$to_day,
				'expenses'  =>$expenses,
				'status_id' =>$status,
				'user_id'   =>$user_id
				);

		Excel::loadView('ExportExcel_View.expense', $data)
			->setTitle('Expense')
			->sheet('EX')
			->export('xls');
	});

	// Export to excel in New Transaction
	Route::post('new-transaction', function(){
		if (!empty(Cache::get('cart'))) {
			Excel::loadView('ExportExcel_View.new_transaction')
					->setTitle('New_Transaction')
					->sheet('NT')
					->export('xls');
		} else {
			$notification = new Notification;
			$notification->set('danger', 'You do not have any transaction to export!!');
			Cache::put('notification', $notification, 10);
			return Redirect::to('inventory/create');
		}
	});
});

// test route
Route::get('test', function(){
	
	$test = Report::find(3);
	$result = $test->countEquipment();
	print_r($result);
	// Cache::forget('inspections');
	// Cache::forget('calibrations');
});

