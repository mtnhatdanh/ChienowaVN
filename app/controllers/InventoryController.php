<?php
/**
* InventoryController Class
*/
class InventoryController extends Controller
{


	public function __construct(){
		Session::put('active_menu', 'inventory');
	}

	/**
	 * inventory/create-import
	 * @return View Inventory_View.create
	 */
	public function getCreate(){
		$itematts     = ItemAtt::where('attribute_id', '=', 1)->get();
		$notification = Cache::get('notification');
		$data         = array('itematts'=>$itematts,'notification'=>$notification);
		Cache::forget('notification');
		return View::make('Inventory_View.create', $data);
	}

	/**
	 * push Transaction to Cart
	 * @return Cache cart
	 */
	public function postCart(){
		$rules = array(
			"type"    =>"required|max:1",
			"date"    =>"required|date",
			"item_id" =>"required|integer",
			"amount"  =>"required|numeric"
			);

		if (Input::get('type')=="E") {
			$inStock = Item::find(Input::get('item_id'))->getInStock();
			if(Input::get('amount')>$inStock['inStock']) return "The amount is excess the instock!!";
		}

		if (!Validator::make(Input::all(), $rules)->fails()) {
			$transaction          = new Transaction();
			$transaction->date    = Input::get('date');
			$transaction->item_id = Input::get('item_id');
			$transaction->type    = Input::get('type');
			$transaction->amount  = Input::get('amount');
			$transaction->note    = Input::get('note');

			if (!Cache::has('cart')) {
				$cart   = array();
				$cart[] = $transaction;
				Cache::put('cart', $cart, 10);
			} else {
				$cart = Cache::get('cart');
				$cart[] = $transaction;
				Cache::put('cart', $cart, 10);
			}

			// $notification = new Notification;
			// $notification->type = "success";
			// $notification->value = "Transaction has been push to Cart Table!!";
			// Cache::put('notification', $notification, 10);
			return Redirect::to('inventory/create');
		} else echo "Validator fails";
	}

	public function postCartHandle(){
		$key = Input::get('key');
		$cart = Cache::get('cart');
		unset($cart[$key]);
		Cache::put('cart', $cart, 10);
	}

	/**
	 * Confirm Transaction button
	 * @return Update database
	 */
	public function postConfirmTransaction(){
		if (!empty(Cache::get('cart'))) {
			$cart = Cache::get('cart');
			foreach ($cart as $transaction) {
				$transaction->save();
			}

			$notification        = new Notification;
			$notification->type  = "success";
			$notification->value = "Transaction has been created successful!!";

			Cache::forget('cart');

		} else {
			$notification = new Notification;
			$notification->set('danger', 'Your cart is empty!!');

		}
		Cache::put('notification', $notification, 10);
		return Redirect::to('inventory/create');

	}

	/**
	 * Get data from Create Import - ajax ItemInfo
	 * @return View Invetory_View.item_info
	 */
	public function postItemInfo(){
		$item_id = Input::get('item_id');
		$item = Item::find($item_id);
		$data = array('item'=>$item);
		return View::make('Inventory_View.item_info', $data);
	}

	/**
	 * Get Data to PickCategory ajax
	 * @return View Inventory_View.pick_category
	 */
	public function postPickCategory(){
		$category_id = Input::get('category_id');

		$references = Reference::join('attributes', 'attributes.id', '=', 'references.attribute_id')
			->where('category_id', '=', $category_id)
			->where('attribute_id', '!=', 1)
			->where('attribute_id', '!=', 8)
			->orderBy('order_no', 'asc')->get();

		$data        = array(
			"category_id" =>$category_id,
			"references"  =>$references
			);
		return View::make('Inventory_View.pick_category', $data);

	}

	public function postLookupItem(){
		$category_id  = Input::get('category_id');
		$attribute_id = Input::get('attribute_id');
		$value        = Input::get('value');

		if (!$attribute_id || !$value) {
			$items = Item::where('category_id', '=', $category_id)->get();
		} else {
			$items = Item::where('category_id', '=', $category_id)
				->join('item_atts', 'item_atts.item_id', '=', 'items.id')
				->where('attribute_id', '=', $attribute_id)
				->where('value', 'like', '%'.$value.'%' )
				->get();
		}

		$data = array('items'=>$items);

		return View::make('Inventory_View.lookup_item', $data);
	}

	/**
	 * /inventory/manage
	 * @return View manage view
	 */
	public function getManage(){
		$notification = Cache::get('notification');
		Cache::forget('notification');
		return View::make('Inventory_View.manage', array('notification'=>$notification));
	}

	/**
	 * get data from Manage View
	 * @return View ajax 
	 */
	public function postManage(){
		$from_day     = Input::get('from_day');
		$to_day       = Input::get('to_day');
		$transactions = Transaction::whereBetween('date', array($from_day, $to_day))->orderBy('date', 'asc')->get();
		return View::make('Inventory_View.manage_table', array('transactions'=>$transactions));
	}

	/**
	 * getData to Delete Transaction
	 * @return Redirect to View
	 */
	public function postDeleteTransaction(){
		$transaction_id = Input::get('transaction_id');
		$rules = array(
			"transaction_id"    =>"required|min:1"
			);

		if (!Validator::make(Input::all(), $rules)->fails()) {
			$transaction         = Transaction::find($transaction_id)->delete();
			$notification        = new Notification;
			$notification->type  = "success";
			$notification->value = "You have just deleted transaction!!";
			Cache::put('notification', $notification, 10);
			return Redirect::to('inventory/manage');
		}
	}

	/**
	 * Modify Transaction
	 * @param  ID $transaction_id 
	 * @return View                 Modify VIew
	 */
	public function getModify($transaction_id) {
		$transaction = Transaction::find($transaction_id);
		return View::make('Inventory_View.modify', array('transaction'=>$transaction));
	}

	public function postModify($transaction_id) {

		$transaction = Transaction::find($transaction_id);

		$rules = array(
			"amount"  =>"required|numeric"
			);

		if ($transaction->type=="E") {
			$inStock = $transaction->item->getInStock();
			if(Input::get('amount')>$inStock['inStock']) return "The amount is excess the instock!!";
		}

		if (!Validator::make(Input::all(), $rules)->fails()) {
			$transaction->amount  = Input::get('amount');
			$transaction->note    = Input::get('note');
			$transaction->save();

			$notification        = new Notification;
			$notification->type  = "success";
			$notification->value = "Transaction has been updated successful!!";
			Cache::put('notification', $notification, 10);
			return Redirect::to('inventory/manage');
		} else echo "Validator fails";

	}

}
