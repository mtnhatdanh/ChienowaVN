<?php
/**
* Report Class
*/
class ReportController extends Controller
{


	public function __construct(){
		Session::put('active_menu', 'report');
	}

	public function getInventoryInStock(){
		// $items = Item::join('transactions', 'transactions.item_id', '=', 'items.id')
		// 		->select(DB::raw('sum(amount) as total, item_id, type'))
		$items_inStock = array();
		$items = Transaction::groupBy('item_id')->get();
		return View::make('Report_View.inventory_in_stock');
	}

}