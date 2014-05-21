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
		$quotation->due_date    = Input::get('Due_date');
		$quotation->status      = Input::get('status');
		$quotation->note        = Input::get('note');

		$success = $quotation->save();

		$data = array('quotation'=>$quotation);

		if ($success) {

			$quotation_id = $quotation->id;

			$diff = abs(strtotime($quotation->due_date) - strtotime($quotation->date));

			Mail::later($diff, 'Mail_View.quotation-mail', array('quotation_id'=>$quotation_id), function($message){
				$message->to('minhgiang0801@outlook.com', 'Minh Giang Outlook')->subject('Quotation statement from Chienowa!!');
			});

			$notification = new Notification;
			$notification->set('success', 'Create new Quotation successfully!!');
			Cache::put('notification', $notification, 10);
			return Redirect::to('orders/quotation-create');

		} else {
			return Response::json($quotation->errors(), 400);
		}

	}
	
}
