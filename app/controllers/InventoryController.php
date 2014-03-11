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
		$notification = Session::get('notification_transaction');
		$data         = array('itematts'=>$itematts,'notification'=>$notification);
		Session::forget('notification_transaction');
		return View::make('Inventory_View.create', $data);
	}

	/**
	 * get post data from inventory/create
	 * @return new data to transactions table
	 */
	public function postCreate(){
		$rules = array(
			"type"    =>"required|max:1",
			"date"    =>"required|date",
			"item_id" =>"required|integer",
			"amount"  =>"required|numeric"
			);

		if (Input::get('type')=="E") {
			$inStock = Item::getInStock(Input::get('item_id'));
			if(Input::get('amount')>$inStock) return "The amount is excess the instock!!";
		}

		if (!Validator::make(Input::all(), $rules)->fails()) {
			$transaction          = new Transaction();
			$transaction->date    = Input::get('date');
			$transaction->item_id = Input::get('item_id');
			$transaction->type    = Input::get('type');
			$transaction->amount  = Input::get('amount');
			$transaction->note    = Input::get('note');
			$transaction->save();
			Session::put('notification_transaction', 'Transaction has been created successful!!');
			return Redirect::to('inventory/create');
		} else echo "Validator fails";
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

}
