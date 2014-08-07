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

	/**
	 * Quality Control report
	 * @return View
	 */
	public function getQualityControl(){
		return View::make('Report_View.quality_control');
	}

	public function postQualityControl(){

		$from_day   = Input::get('from_day');
		$to_day     = Input::get('to_day');
		$product_id = Input::get('product_id');

		$reports = Report::whereBetween('date', array($from_day, $to_day))
					->where('product_id', '=', $product_id)
					->orderBy('date', 'asc')->get();

		Cache::forget('calibrations');
		Cache::forget('inspections');

		return View::make('Report_View.quality_control_table', array('reports'=>$reports));
	}

	/**
	 * Order Product report
	 * @return View Order Product
	 */
	public function getOrderProductDetail(){
		return View::make('Report_View.order-product-detail');
	}

	/**
	 * show Ajax order/order-product-detail
	 * @return Ajax View
	 */
	public function postOrderProductDetail(){
		$from_day         = Input::get('from_day');
		$to_day           = Input::get('to_day');
		$order_product_id = Input::get('order_product_id');

		$orderDetailTable = DB::table('order_details')
							->join('orders', 'order_details.order_id', '=', 'orders.id')
							->where('order_details.order_product_id', '=', $order_product_id);
						
		if ($from_day != '') {
			$orderDetailTable = $orderDetailTable->where('orders.date', '>=', $from_day);
		}
		if ($to_day!= '') {
			$orderDetailTable = $orderDetailTable->where('orders.date', '<=', $to_day);
		}

		$orderDetailTable = $orderDetailTable->orderBy('orders.date', 'asc')->get();

		return View::make('Report_View.order-detail-table', array('orderDetailTable' => $orderDetailTable, 'order_product_id' => $order_product_id));

	}

	/**
	 * Quotation Product report
	 * @return View Quotation Product report
	 */
	public function getQuotationProductDetail(){
		return View::make('Report_View.quotation-product-detail');
	}

	/**
	 * show Ajax order/quotation-product-detail
	 * @return Ajax View
	 */
	public function postQuotationProductDetail(){
		$from_day         = Input::get('from_day');
		$to_day           = Input::get('to_day');
		$order_product_id = Input::get('order_product_id');

		$quotationDetailTable = DB::table('quotation_details')
							->join('quotation', 'quotation_details.quotation_id', '=', 'quotation.id')
							->select('quotation_details.id', 'quotation_details.order_product_id', 'quotation_details.price', 'quotation_details.quantity', 'quotation.date', 'quotation.supplier_id', 'quotation.completed_date', 'quotation_details.price_usd', 'quotation_details.price_jpy')
							->where('quotation.status', '=', 1)
							->where('quotation_details.order_product_id', '=', $order_product_id);
						
		if ($from_day != '') {
			$quotationDetailTable = $quotationDetailTable->where('quotation.date', '>=', $from_day);
		}
		if ($to_day!= '') {
			$quotationDetailTable = $quotationDetailTable->where('quotation.date', '<=', $to_day);
		}

		$quotationDetailTable = $quotationDetailTable->orderBy('quotation.date', 'asc')->get();

		return View::make('Report_View.quotation-detail-table', array('quotationDetailTable' => $quotationDetailTable, 'order_product_id' => $order_product_id));

	}

	/**
	 * Quotation Draw Chart ajax
	 * @return Ajax view
	 */
	public function postQuotationDrawChart() {
		$quotationDetailArray = Input::get('quotationDetailArray');
		return View::make('Report_View.quotation-chart', array('quotationDetailArray'=>$quotationDetailArray));
	}

	/**
	 * Supplier report
	 * @return view
	 */
	public function getSupplierReport() {
		return View::make('Report_View.supplier-report');
	}

	/**
	 * Supplier report ajax
	 * @return View ajax
	 */
	public function postSupplierReport() {
		$statement_type = Input::get('statement_type');
		$from_day       = Input::get('from_day');
		$to_day         = Input::get('to_day');
		$supplier       = Supplier::find(Input::get('supplier_id'));
		$supplier_name  = $supplier->name;

		if ($statement_type == 0) {
			// Get quotations statement of supplier
			$quotations = $supplier->load(array('quotations' => function($query) use ($from_day, $to_day){
				$query->where('status', '=', 1);
				if ($from_day != '') {
					$query->where('date', '>=', $from_day);
				}
				if ($to_day!= '') {
					$query->where('date', '<=', $to_day);
				}
			}))->quotations;

			return View::make('Report_View.supplier-ajax-quotations', array('quotations' => $quotations, 'supplier_name' => $supplier_name));
		} else {
			// Get orders statement of supplier
			$orders = $supplier->load(array('orders' => function($query) use ($from_day, $to_day){
				$query->where('status', '=', 1);
				if ($from_day != '') {
					$query->where('date', '>=', $from_day);
				}
				if ($to_day!= '') {
					$query->where('date', '<=', $to_day);
				}
			}))->orders;


			return View::make('Report_View.supplier-ajax-orders', array('orders' => $orders, 'supplier_name' => $supplier_name));
		}
	}

	/**
	 * [getProjectDetailReport description]
	 * @return View Project Detail report
	 */
	public function getProjectDetailReport(){
		return View::make('Report_View.project-detail-report');
	}

	/**
	 * [postProjectStatusAjax description]
	 * @return Ajax view
	 */
	public function postProjectStatusAjax(){
		$status = Input::get('status');
		$projects = Project::where('status', '=', $status)->get();
		return View::make('Report_View.project-status-ajax', array('projects'=>$projects));
	}

	/**
	 * [postProjectDetailAjax description]
	 * @return Ajax View
	 */
	public function postProjectDetailAjax(){
		$project = Project::find(Input::get('project_id'));
		return View::make('Report_View.project-detail-ajax', array('project'=>$project));
	}

	/**
	 * [postProjectDetailSuggestModal description]
	 * @return Ajax modal for suggest project detail
	 */
	public function postProjectDetailSuggestModal(){
		$projectDetail_id       = Input::get('projectDetail_id');
		$sg_quotation_detail_id = Input::get('sg_quotation_detail_id');
		return View::make('Report_View.project-detail-suggest-modal', array('projectDetail_id'=>$projectDetail_id, 'sg_quotation_detail_id'=>$sg_quotation_detail_id));
	}

	/**
	 * [postProjectDetailSuggestHandle description]
	 * @return Database update
	 */
	public function postProjectDetailSuggestHandle(){
		$projectDetail                         = ProjectDetail::find(Input::get('projectDetail_id'));
		$projectDetail->sg_quotation_detail_id = Input::get('sg_quotation_detail_id');
		$projectDetail->sg_note                = Input::get('sg_note');
		$success = $projectDetail->save();
		if (!$success) {
			return Response::json('error save Project Detail', 400);
		}

		$project = $projectDetail->project;
		return View::make('Report_View.project-detail-ajax', array('project'=>$project));
	}

}