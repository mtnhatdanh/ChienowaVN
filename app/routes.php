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

Queue::getIron()->ssl_verifypeer = false;

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
	Route::controller('orders', 'OrdersController');
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
	// Check valid staff Rank ID exist
	Route::post('check-staffRank', function(){
		if (StaffRank::checkStaffRankExist(Input::get('user_id'))) {
			return "false";
		} else return "true";
	});
	// Check valid Supplier name exist
	Route::post('check-supplier', function(){
		if (Supplier::checkSupplierExist(Input::get('name'))) {
			return "false";
		} else return "true";
	});
	// Check valid Supplier name for new Quotaion, new Order
	Route::post('check-supplier-exist', function(){
		if (Supplier::checkSupplierExist(Input::get('supplier_name'))) {
			return "true";
		} else return "false";
	});
	// Check valid Order Product name
	Route::post('check-order-product', function(){
		if(OrderProduct::check_order_product_exist(Input::get('name'))) {
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
		if (Input::has('report_id')) {
			$report       = Report::find(Input::get('report_id'));
			$date         = $report->date;
			$report_no    = $report->id;
			$calibrations = $report->calibration;
			$calibArray = array();
			foreach ($calibrations as $calibration) {
				$calibArray[] = $calibration;
			}
			Cache::put('calibrations', $calibArray, 720);
		} else {
			$date      = Input::get('date');
			$report_no = Input::get('report_no');
		}
		$data = array(
			'date'      => $date,
			'report_no' => $report_no
			);
		return View::make('Quality_Control_View.calibrations_form_print', $data);
	});

	// Ajax for Daily Quality Control print button
	Route::post('print-quality-report', function(){

		if (Input::has('report_id')) {
			$report = Report::find(Input::get('report_id'));

			$inspections  = $report->inspection;
			$inspectionDetailTable = array();

			foreach ($inspections as $inspection) {
				$inspectionArray = array();
				foreach ($inspection->inspectionDetail as $inspectionDetail) {
					$inspectionArray[] = $inspectionDetail;
				}
				$inspectionDetailTable[] = $inspectionArray;
			}
			Cache::put('inspectionDetailTable', $inspectionDetailTable , 720);

		} else {
			$report = new Report();

			$report                       = new Report;
			$report->product_id           = Input::get('product_id');
			$report->date                 = Input::get('date');
			$report->judgement            = Input::get('judgement');
			$report->app_staff_id         = Input::get('app_staff_id');
			$report->measurement_staff_id = Input::get('measurement_staff_id');
			$report->part_no              = Input::get('part_no');
			$report->part_name            = Input::get('part_name');
			$report->lot_no               = Input::get('lot_no');
			$report->delivery_date        = Input::get('delivery_date');
			$report->sample_qty           = Input::get('sample_qty');
			$report->total_qty            = Input::get('total_qty');
			$report->inspection_qty       = Input::get('inspection_qty');
			$report->judgement_grade      = Input::get('judgement_grade');
			$report->judgement_color      = Input::get('judgement_color');

		}


		$data = array('report' => $report);
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

Route::post('queue/push', function(){
	return Queue::marshal();
});

/**
* Queue class for order send mail
*/
class SendEmail
{
	public function fire($job, $data) {

		$order_id       = $data['order_id'];
		$order          = Order::find($order_id);
		$user_email     = $order->user->email;
		$supplier_email = $order->supplier->email;

		if ($order->status == 0) {
			Mail::queue('Mail_View.order-mail', array('order_id'=>$order_id), function($message) use ($user_email, $supplier_email){
				$message->to($user_email, 'Chienowa Vietnam Staff')
				->cc($supplier_email, 'Supplier')
				->subject('Remind Order statement from Chienowa!!');
			});
		}

		$job->delete();
	}

	// Send email for Request Local function
	public function requestLC($job, $data) {
		
		$request_id  = $data['request_id'];

		$request     = RequestLC::find($request_id);
		$user_email  = $request->user->email;
		$staff_email = $request->inchargeStaff->email;
		

		if ($request->status == 0) {

			Mail::queue('Mail_View.request-mail', array('request_id'=>$request_id), function($message) use ($user_email, $staff_email){
				$message->to($staff_email, 'Staff Chienowa Vietnam')
				->cc($user_email, 'Chienowa Vietnam')
				->subject('Remind Local Request statement from Chienowa!!');
			});
		}

		$job->delete();
	}

}


Route::get('test-complete', function(){
	return View::make('test-complete');
});

// test route
Route::get('test', function(){

	// Queue::push('SendEmail@requestLC', array('request_id'=>7));
	// echo "ok";
	// 
	
	// $orderDetail = OrderDetail::find(1);
	// print_r($orderDetail);
	// echo "<br/>";
	// 

	// $orderProduct = OrderProduct::find(4);
	// print_r($orderProduct->orderDetails);
	// print_r($orderDetail->orderProduct->name);
	$order = Order::find(10);
	print_r($order->supplier->email);
	// return View::make('Mail_View.order-mail', array('order_id'=>14));		

	// $request->save();

	// print_r($request);

	// $user = User::find(10);
	// print_r($user);
	


	// Queue::push(function($job){
	// 	File::append(app_path().'/queue.txt', 'Test Queue Laravel'.PHP_EOL);
	// 	$job->delete();
	// });

	// return "ok";
	
});
