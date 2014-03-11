<?php
/**
* Report Class
*/
class ReportController extends Controller
{


	public function __construct(){
		Session::put('active_menu', 'report');
	}

	/**
	 * [getInventoryInStock description]
	 * @return View Report_View.inventory_in_stock
	 */
	public function getInventoryInStock(){
		return View::make('Report_View.inventory_in_stock');
	}

	/**
	 * /report/inventory-by-day
	 * @return View Inventory_by_day
	 */
	public function getInventoryByDay(){
		return View::make('Report_View.inventory_by_day');
	}

	/**
	 * get Ajax from InventoryByDay report
	 * @return View [description]
	 */
	public function postInventoryFilter(){
		$category_id = Input::get('category_id');
		$from_day    = Input::get('from_day');
		$to_day      = Input::get('to_day');

		$items = Item::where('category_id', '=', $category_id)->get();
		$data  = array(
			'items'    =>$items,
			'from_day' =>$from_day,
			'to_day'   =>$to_day
			);

		return View::make('Report_View.inventory_filter', $data);
	}



}