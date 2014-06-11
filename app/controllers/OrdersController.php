<?php
/**
* OrdersController Class
*/
class OrdersController extends Controller
{

	public function __construct(){
		Session::put('active_menu', 'orders');
	}
	
	public function getSupplierManage(){
		$notification = Cache::get('notification');
		Cache::forget('notification');
		return View::make('Orders_View.supplier-manage', array('notification'=>$notification));
	}

	/**
	 * Supplier Create
	 * @return New Supplier
	 */
	public function postSupplierCreate(){
		$supplier                 = new Supplier;
		$supplier->name           = Input::get('name');
		$supplier->address        = Input::get('address');
		$supplier->email          = Input::get('email');
		$supplier->phone          = Input::get('phone');
		$supplier->representative = Input::get('representative');
		$supplier->mobile         = Input::get('mobile');
		$supplier->website        = Input::get('website');
		$supplier->note           = Input::get('note');
		$supplier->main_product   = Input::get('main_product');
		$supplier->rating         = Input::get('rating');

		$success = $supplier->save();

		if ($success) {
			$notification = new Notification;
			$notification->set('success', 'New supplier has been create successfully!!');
			Cache::put('notification', $notification, 10);
			return Redirect::to('orders/supplier-manage');
		} else {
			return Response::json('error', 400);
		}
	}

	/**
	 * Supplier Info
	 * @return Ajax
	 */
	public function postSupplierInfo(){
		$supplier_id = Input::get('supplier_id');
		$supplier    = Supplier::find($supplier_id);
		return View::make('Orders_View.supplier-info', array('supplier'=>$supplier));
	}

	/**
	 * Supplier Delete
	 * @return Update database
	 */
	public function postSupplierDelete(){
		$supplier_id = Input::get('supplier_id');
		$supplier    = Supplier::find($supplier_id);
		$supplier->delete();

		$notification = new Notification;
		$notification->set('success', 'Delete Supplier successfully!!');
		Cache::put('notification', $notification, 10);

		return Redirect::to('orders/supplier-manage');
	}

	/**
	 * Supplier Modify ajax
	 * @return Update database
	 */
	public function postSupplierModify(){
		$supplier = Supplier::find(Input::get('supplier_id'));
		return View::make('Orders_View.supplier-modify', array('supplier'=>$supplier));
	}

	/**
	 * Supplier Modify 
	 * @return Update database
	 */
	public function postSupplierModifyConfirm(){
		$supplier                 = Supplier::find(Input::get('supplier_id'));
		$supplier->name           = Input::get('name');
		$supplier->address        = Input::get('address');
		$supplier->email          = Input::get('email');
		$supplier->phone          = Input::get('phone');
		$supplier->representative = Input::get('representative');
		$supplier->mobile         = Input::get('mobile');
		$supplier->website        = Input::get('website');
		$supplier->note           = Input::get('note');
		$supplier->main_product   = Input::get('main_product');
		$supplier->rating         = Input::get('rating');

		$success = $supplier->updateUniques();

		if ($success) {
			$notification = new Notification;
			$notification->set('success', 'New supplier has been update successfully!!');
			Cache::put('notification', $notification, 10);
			return Redirect::to('orders/supplier-manage');
		} else {
			return Response::json('error', 400);
		}
	}

	// Quotation area
	
	/**
	 * Quotation Manage
	 * @return View quotation
	 */
	public function getQuotationManage(){
		$notification = Cache::get('notification');
		Cache::forget('notification');
		return View::make('Orders_View.quotation-manage', array('notification'=>$notification));		
	}

	/**
	 * Quotation Manage post
	 * @return ajax view
	 */
	public function postQuotationManage(){
		$from_date = Input::get('from_date');
		$to_date   = Input::get('to_date');
		$status    = Input::get('status');

		$quotations = Quotation::where('status', '=', $status);
						
		if ($from_date != '') {
			$quotations = $quotations->where('date', '>=', $from_date);
		}
		if ($to_date!= '') {
			$quotations = $quotations->where('date', '<=', $to_date);
		}

		$quotations = $quotations->get();

		return View::make('Orders_View.quotation-ajax', array('quotations'=>$quotations, 'status'=>$status));
	}

	/**
	 * Quotation Status Change ajax
	 * @return Update database
	 */
	public function postQuotationChangeStatus(){
		$quotation         = Quotation::find(Input::get('quotation_id'));
		$quotation->status = Input::get('status');

		if (Input::get('status') == 1) {
			$quotation->completed_date = date('Y-m-d');
		}

		$success           = $quotation->save();
		
		if ($success) {
			echo 'OK';
		} else {echo 'error';}
	}

	/**
	 * Quotation Create
	 * @return View quotation
	 */
	public function getQuotationCreate(){
		$notification = Cache::get('notification');
		Cache::forget('notification');
		return View::make('Orders_View.quotation-create', array('notification'=>$notification));			
	}


	/**
	 * Supplier Autocomplete for Quotation
	 * @return JSON
	 */
	public function getSupplierAutocomplete(){
		return View::make('Orders_View.supplier-autocomplete');
	}

	/**
	 * Supplier Lookup ajax
	 * @return Ajax
	 */
	public function postSupplierLookup(){
		$search_name           = Input::get('Search_name');
		$search_main_products  = Input::get('Search_main_Products');
		$search_repersentative = Input::get('Search_repersentative');
		$search_rating         = Input::get('rating');

		if (isset($search_name)) {
			$result = Supplier::where('name', 'like', '%'.$search_name.'%');
		} else $result = Supplier::whereRaw('1 = 1');
		
		if (isset($search_main_products)) {
			$result = $result->where('main_product', 'like', '%'.$search_main_products.'%');
		}

		if (isset($search_repersentative)) {
			$result = $result->where('representative', 'like', '%'.$search_repersentative.'%');
		}

		if (isset($search_rating)) {
			$result = $result->where('rating', '=', $search_rating);
		}

		$result = $result->get();

		return View::make('Orders_View.supplier-lookup', array('suppliers'=>$result));

	}

	/**
	 * New Quotation
	 * @return Database new quotation
	 */
	public function postQuotationNew(){
		$quotation              = new Quotation;
		$quotation->user_id     = Input::get('user_id');
		$quotation->date        = Input::get('date');
		$quotation->supplier_id = Input::get('supplier_id');
		$quotation->product     = Input::get('Product');
		$quotation->status      = 0;
		$quotation->note        = Input::get('note');

		$success = $quotation->save();
		$quotation_id = $quotation->id;

		$user_email = User::find(Input::get('user_id'))->email;

		$data = array('quotation'=>$quotation);

		if ($success) {

			Mail::queue('Mail_View.quotation-mail', array('quotation_id'=>$quotation_id), function($message) use ($user_email){
				$message->to($user_email, 'Chienowa Vietnam Staff')->subject('Quotation statement from Chienowa!!');
			});

			$notification = new Notification;
			$notification->set('success', 'Create new Quotation successfully!!');
			Cache::put('notification', $notification, 10);
			return Redirect::to('orders/quotation-create');

		} else {
			return Response::json('error', 400);
		}

	}

	/**
	 * Orders/order-create
	 * @return View Order-create
	 */
	public function getOrderCreate(){
		$notification = Cache::get('notification');
		Cache::forget('notification');
		return View::make('Orders_View.order-create', array('notification'=>$notification));					
	}

	/**
	 * post orders/order-create
	 * @return Update database
	 */
	public function postOrderCreate(){
		$order                = new Order;
		$order->user_id       = Input::get('user_id');
		$order->date          = Input::get('date');
		$order->supplier_id   = Input::get('supplier_id');
		$order->order_product = Input::get('product');
		$order->due_date      = Input::get('due_date');
		$order->delivery_date = Input::get('delivery_date');
		$order->status        = Input::get('status');
		$order->note          = Input::get('note');

		$success = $order->save();

		if ($success) {
			$order_id = $order->id;
			Mail::queue('Mail_View.order-mail', array('order_id'=>$order_id), function($message){
				$message->to('hoainfo@chienowa.agri-wave.com', 'Hoa Chienowa')
				->cc('minhgiang0801@outlook.com', 'Minh Giang')
				->subject('Remind Order statement from Chienowa!!');
			});

			$diff       = abs(strtotime($order->due_date) - strtotime($order->date));
			$before1day = $diff - 86400;
			$after1day  = $diff + 86400;

			// Send email 1 day before Due_date
			if ($before1day>0) {
				Queue::later($before1day, 'SendEmail', array('order_id'=>$order_id));
			}

			// Send email 1 day after Due_date
			Queue::later($after1day, 'SendEmail', array('order_id'=>$order_id));
			
			
			$notification = new Notification;
			$notification->set('success', 'Create new Order successfully!!');
			Cache::put('notification', $notification, 10);
			return Redirect::to('orders/order-create');

		} else {
			return Response::json('error', 400);
		}
	}

	/**
	 * Order Manage
	 * @return View order-manage
	 */
	public function getOrderManage(){
		$notification = Cache::get('notification');
		Cache::forget('notification');
		return View::make('Orders_View.order-manage', array('notification'=>$notification));
	}

	/**
	 * Quotation Manage post
	 * @return ajax view
	 */
	public function postOrderManage(){
		$from_date = Input::get('from_date');
		$to_date   = Input::get('to_date');
		$status    = Input::get('status');

		$orders = Order::where('status', '=', $status);
						
		if ($from_date != '') {
			$orders = $orders->where('date', '>=', $from_date);
		}
		if ($to_date!= '') {
			$orders = $orders->where('date', '<=', $to_date);
		}

		$orders = $orders->get();

		return View::make('Orders_View.order-ajax', array('orders'=>$orders));
	}

	/**
	 * Delete Order
	 * @return Update database
	 */
	public function postOrderDelete(){
		$order = Order::find(Input::get('order_id'));
		$order->delete();
		$notification        = new Notification;
		$notification->type  = "success";
		$notification->value = "You have just deleted order!!";
		Cache::put('notification', $notification, 10);
		return Redirect::to('orders/order-manage');
	}

	/**
	 * Order Modify ajax
	 * @return View ajax
	 */
	public function postOrderModify(){
		$order = Order::find(Input::get('order_id'));
		return View::make('Orders_View.order-modify-ajax', array('order'=>$order));
	}

	/**
	 * Order Modify Confirm from ajax
	 * @return Update Database
	 */
	public function postOrderModifyConfirm(){
		$order                = Order::find(Input::get('order_id'));
		$order->status        = Input::get('status');
		$order->delivery_date = Input::get('delivery_date');
		$order->note          = Input::get('note');
		$success = $order->save();
		if ($success) {
			$notification = new Notification;
			$notification->set('success', 'You have just updated Order!!');
			Cache::put('notification', $notification, 10);
			return Redirect::to('orders/order-manage'); 
		} else {
			return Response::json('error', 400);
		}
	}

	/**
	 * orders/request-create
	 * @return View request-create
	 */
	public function getRequestCreate(){
		$notification = Cache::get('notification');
		Cache::forget('notification');
		return View::make('Orders_View.request-create', array('notification'=>$notification));
	}

	/**
	 * get data from Request Create
	 * @return Update database
	 */
	public function postRequestCreate(){
		$request = new RequestLC;
		$request->user_id           = Input::get('user_id');
		$request->date              = Input::get('date');
		$request->incharge_staff_id = Input::get('incharge_staff_id');
		$request->due_date          = Input::get('due_date');
		$request->request_content   = Input::get('request_content');
		$request->note              = Input::get('note');

		$success = $request->save();

		$request_id = $request->id;

		$notification = new Notification;

		if ($success) {

			Queue::push('SendEmail@requestLC', array('request_id'=>$request_id));

			$diff       = abs(strtotime($request->due_date) - strtotime(date('Y-m-d')));
			$before1day = $diff - 86400;
			$after1day  = $diff + 86400;

			if ($before1day) {
				Queue::later($before1day, 'SendEmail@requestLC', array('request_id'=>$request_id));
			}
			
			if ($diff) {
				Queue::later($diff, 'SendEmail@requestLC', array('request_id'=>$request_id));
			}
			
			if ($after1day) {
				Queue::later($after1day, 'SendEmail@requestLC', array('request_id'=>$request_id));
			}
			

			$notification->set('success', 'You have just created new Request!!');

		} else {
			$notification->set('danger', 'Fail!!');
		}
		Cache::put('notification', $notification, 10);
		return Redirect::to('orders/request-create');
	}

	/**
	 * Request Manage
	 * @return View
	 */
	public function getRequestManage(){
		$user_id = Session::get('user')->id;
		$user    = User::find($user_id);

		$notification = Cache::get('notification');
		Cache::forget('notification');
		return View::make('Orders_View.request-manage', array('notification'=>$notification, 'user'=>$user));
	}

	/**
	 * Request Manage ajax
	 * @return View ajax
	 */
	public function postRequestManage(){

		$from_date = Input::get('from_date');
		$to_date   = Input::get('to_date');
		$status    = Input::get('status');

		$requests = RequestLC::where('status', '=', $status);
						
		if ($from_date != '') {
			$requests = $requests->where('date', '>=', $from_date);
		}
		if ($to_date!= '') {
			$requests = $requests->where('date', '<=', $to_date);
		}

		$requests = $requests->get();

		return View::make('request_View.request-ajax', array('requests'=>$requests));
	}
	
}
