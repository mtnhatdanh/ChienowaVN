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
		return View::make('Expense_View.create');
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
			return Redirect::to('expense/manage-expense');
		}
	}

	public function getManageExpense(){
		echo "manage expense";
	}

}
