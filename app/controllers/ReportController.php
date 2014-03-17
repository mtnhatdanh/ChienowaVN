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

	/**
	 * report/transactions
	 * @return View Transactions View
	 */
	public function getTransactions(){
		return View::make('Report_View.inventory_transactions');
	}

	/**
	 * Report Transaction Amax
	 * @return View Table transactions
	 */
	public function postTransactionsFilter(){
		$from_day = Input::get('from_day');
		$to_day   = Input::get('to_day');
		$type     = Input::get('type');
		if ($type == "A") {
			$transactions = Transaction::whereBetween('date', array($from_day, $to_day))->orderBy('date', 'asc')->get();
		} else {
			$transactions = Transaction::whereBetween('date', array($from_day, $to_day))->where('type', '=', $type)->orderBy('date', 'asc')->get();
		}
		return View::make('Report_View.transactions_ajax', array('transactions'=>$transactions));
	}

	/**
	 * Expense report
	 * @return View
	 */
	public function getExpense(){
		$users = User::where('id', '!=', 16)->get();
		return View::make('Report_View.expense', array('users'=>$users));
	}

	/**
	 * ajax for expense report /report/expense
	 * @return Table
	 */
	public function postExpense(){
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

		return View::make('Report_View.expense_table', array('expenses'=>$expenses));

	}

}