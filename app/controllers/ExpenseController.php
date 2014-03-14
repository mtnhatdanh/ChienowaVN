<?php
/**
* ExpenseController Class
*/
class ExpenseController extends Controller
{


	public function __construct(){
		Session::put('active_menu', 'expense');
	}

	public function getIndex(){
		return $this->getManageExpense();
	}

	/**
	 * /expense/create-expense
	 * @return View Expense_View.create
	 */
	public function getCreateExpense(){
		$notification = Session::get('notification_expense');
		$data         = array('notification'=>$notification);
		Session::forget('notification_expense');
		return View::make('Expense_View.create', $data);
	}

	/**
	 * get data from Create-Expense form
	 * @return View expense/manage-expense
	 */
	public function postCreateExpense(){
		$rules = array(
			"date"        =>"required|date",
			"user_id"     =>"required|integer",
			"amount"      =>"required|integer|min:1",
			"description" =>"required"
			);
		
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			echo "Validator fails";
		} else {
			$expense          = New Expense();
			$expense->date    = Input::get('date');
			$expense->user_id = Input::get('user_id');
			$expense->amount  = Input::get('amount');
			if (Input::get('approved')) $expense->status = 1;
			else $expense->status = 0;
			$expense->description = Input::get('description');
			$expense->save();
			Session::put('notification_expense', 'Expense has been created successful!!');
			return Redirect::to('expense/create-expense');
		}
	}

	/**
	 * expense/manage-expense
	 * @return View
	 */
	public function getManageExpense(){
		return View::make('Expense_View.manage');
	}

	/**
	 * get post data for ajax
	 * @return View Expense_View.manage_ajax
	 */
	public function postManageExpense(){

		$from_day = Input::get('from_day');
		$to_day   = Input::get('to_day');
		$expenses = Expense::whereBetween('date', array($from_day, $to_day))->orderBy('date', 'asc')->get();

		return View::make('Expense_View.manage_ajax', array('expenses'=>$expenses));

	}

	/**
	 * ajx Update status for manage expense
	 * @return none
	 */
	public function postUpdateStatus(){
		$expense_id = Input::get('expense_id');
		$status     = Input::get('status');
		$expense    = Expense::find($expense_id);
		$expense->status = $status;
		$expense->save();
	}

	/**
	 * modify expense
	 * @param  integer $expense_id Expense ID
	 * @return View             
	 */
	public function getModify($expense_id){
		$expense = Expense::find($expense_id);
		return View::make('Expense_View.modify', array('expense'=>$expense));

	}

	public function postModify($expense_id){
		$rules = array(
			"date"        =>"required|date",
			"user_id"     =>"required|integer",
			"amount"      =>"required|integer|min:1",
			"description" =>"required"
			);
		
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			echo "Validator fails";
		} else {
			$expense          = Expense::find($expense_id);
			$expense->date    = Input::get('date');
			$expense->user_id = Input::get('user_id');
			$expense->amount  = Input::get('amount');
			if (Input::get('approved')) $expense->status = 1;
			else $expense->status = 0;
			$expense->description = Input::get('description');
			$expense->save();
			return Redirect::to('expense/manage-expense');
		}
	}

}
