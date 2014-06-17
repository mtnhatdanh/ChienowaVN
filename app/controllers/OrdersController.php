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
		Cache::forget('orderDetailCart');
		$notification = Cache::get('notification');
		Cache::forget('notification');
		return View::make('Orders_View.order-create', array('notification'=>$notification));					
	}

	/**
	 * post orders/order-create
	 * @return Update database
	 */
	public function postOrderCreate(){

		if (!Cache::has('orderDetailCart')) {
			$notification = new Notification;
			$notification->set('danger', 'Fail to create new oder!!');
			Cache::put('notification', $notification, 10);
			return Redirect::to('orders/order-create');
		} else {
			if (empty(Cache::get('orderDetailCart'))) {
				$notification = new Notification;
				$notification->set('danger', 'Fail to create new oder!!');
				Cache::put('notification', $notification, 10);
				return Redirect::to('orders/order-create');
			}
		}

		$order              = new Order;
		$order->user_id     = Input::get('user_id');
		$order->date        = Input::get('date');
		$order->supplier_id = Input::get('supplier_id');
		$order->due_date    = Input::get('due_date');
		$order->status      = 0;
		$order->note        = Input::get('note');

		$success = $order->save();

		if ($success) {

			// Save order detail
			$order_id = $order->id;
			$orderDetailCart = Cache::get('orderDetailCart');
			foreach ($orderDetailCart as $orderProduct_id => $orderDetail) {
				$or_detail                  = $orderDetail;
				$or_detail->order_id        = $order_id;
				$or_detail->order_product_id = $orderProduct_id;
				$successOD = $or_detail->save();
				if (!$successOD) {
					return Response::json('Error save OrderDetail', 400);
				}
			}

			Queue::push('SendEmail', array('order_id'=>$order_id));

			$diff       = strtotime($order->due_date) - strtotime(date('Y-m-d'));
			$before1day = $diff - 86400;
			$after1day  = $diff + 86400;

			// Send email 1 day before Due_date
			if ($before1day>0) {
				Queue::later($before1day, 'SendEmail', array('order_id'=>$order_id));
			}

			// // Send email 1 day after Due_date
			Queue::later($after1day, 'SendEmail', array('order_id'=>$order_id));
			
			
			$notification = new Notification;
			$notification->set('success', 'Create new Order successfully!!');
			Cache::put('notification', $notification, 10);
			return Redirect::to('orders/order-create');

		} else {
			return Response::json('error create new Order', 400);
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
	 * Order Product detail ajax
	 * @return Ajax view
	 */
	public function postOrderProductShow(){
		$order        = Order::find(Input::get('order_id'));
		$orderDetails = $order->orderDetails;
		return View::make('Orders_View.order-product-show', array('orderDetails'=>$orderDetails));
	}

	/**
	 * Delete Order
	 * @return Update database
	 */
	public function postOrderDelete(){
		$order = Order::find(Input::get('order_id'));
		foreach ($order->orderDetails as $orderDetail) {
			$orderDetail->delete();
		}
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
	public function getOrderModify($order_id){
		$order = Order::find($order_id);
		$notification = Cache::get('notification');
		Cache::forget('notification');
		
		// Push orderDetails to Cache
		Cache::forget('orderDetailCart');
		$orderDetailCart = array();
		foreach ($order->orderDetails as $or_detail) {

			$orderDetail           = new OrderDetail;
			$orderDetail->price    = $or_detail->price;
			$orderDetail->quantity = $or_detail->quantity;

			$orderDetailCart[$or_detail->order_product_id] = $orderDetail;
		}
		Cache::put('orderDetailCart', $orderDetailCart, 10);

		return View::make('Orders_View.order-modify', array('order'=>$order, 'notification'=>$notification));
	}

	/**
	 * Order Modify Confirm from ajax
	 * @return Update Database
	 */
	public function postOrderModify($order_id){

		if (!Cache::has('orderDetailCart')) {
			$notification = new Notification;
			$notification->set('danger', 'Your Product Cart is empty!!');
			Cache::put('notification', $notification, 10);
			return Redirect::to('orders/order-modify/'.$order_id);
		} else {
			if (empty(Cache::get('orderDetailCart'))) {
				$notification = new Notification;
				$notification->set('danger', 'Your Product Cart is empty!!');
				Cache::put('notification', $notification, 10);
				return Redirect::to('orders/order-modify/'.$order_id);
			}
		}

		$order              = Order::find($order_id);
		$order->user_id     = Input::get('user_id');
		$order->date        = Input::get('date');
		$order->supplier_id = Input::get('supplier_id');
		$order->due_date    = Input::get('due_date');
		$order->status      = Input::get('status');
		$order->note        = Input::get('note');

		$success = $order->save();

		if ($success) {

			// Delete old OrderDetails
			foreach ($order->orderDetails as $orderDetail) {
				$orderDetail->delete();
			}

			// Save order detail
			$orderDetailCart = Cache::get('orderDetailCart');
			foreach ($orderDetailCart as $orderProduct_id => $orderDetail) {
				$or_detail                  = $orderDetail;
				$or_detail->order_id        = $order_id;
				$or_detail->order_product_id = $orderProduct_id;
				$successOD = $or_detail->save();
				if (!$successOD) {
					return Response::json('Error save OrderDetail', 400);
				}
			}
			
			
			$notification = new Notification;
			$notification->set('success', 'Update Order successfully!!');
			Cache::put('notification', $notification, 10);
			return Redirect::to('orders/order-modify/'.$order_id);

		} else {
			return Response::json('Error create new Order', 400);
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

	/**
	 * orders/order-product-manage
	 * @return View manage order product
	 */
	public function getOrderProductManage() {
		$notification = Cache::get('notification');
		Cache::forget('notification');
		return View::make('Orders_View.order-product-manage', array('notification'=>$notification));
	}

	/**
	 * orders/order-product-create
	 * @return Update database
	 */
	public function postOrderProductCreate() {

		$orderProduct = new OrderProduct;
		$orderProduct->name = Input::get('name');
		$orderProduct->note = Input::get('note');

		$success = $orderProduct->save();
		if ($success) {
			$notification = new Notification;
			$notification->set('success', 'You have created new Order Product!!');
			Cache::put('notification', $notification, 10);
			return Redirect::to('orders/order-product-manage');
		} else {
			return Response::json('error', 400);
		}

	}

	/**
	 * Order Product delete
	 * @return Update database
	 */
	public function postOrderProductDelete(){
		$orderProduct = OrderProduct::find(Input::get('orderProduct_id'));
		$orderProduct->delete();

		return Redirect::to('orders/order-product-manage');
	}

	/**
	 * handle oderProduct to new Order view
	 * @return [type] [description]
	 */
	public function postOrderProductHandleCache() {
		$type = Input::get('type');

		if (Cache::has('orderDetailCart')) {
			$orderDetailCart = Cache::get('orderDetailCart');
		} else $orderDetailCart = array();

		if ($type == 1) {

			$order_product_id      = Input::get('order_product_id');
			$orderDetail           = new OrderDetail;
			
			$orderDetail->price    = Input::get('order_product_price');
			$orderDetail->quantity = Input::get('order_product_quantity');

			$orderDetailCart[$order_product_id] = $orderDetail;
		} elseif ($type == 2) {
			
			$order_product_id = Input::get('order_product_id');
			unset($orderDetailCart[$order_product_id]);

		}

		if (empty($orderDetailCart)) {
			Cache::forget('orderDetailCart');
		} else {
			Cache::put('orderDetailCart', $orderDetailCart, 10);	
		}
		
		return View::make('Orders_View.order-detail-cart');

	}
	
}
