<?php
/**
* QualityControlController Class
*/
class QualityControlController extends Controller
{


	public function __construct(){
		Session::put('active_menu', 'projects');
	}

	/**
	 * [getMeasuringEquipment description]
	 * @return View Quility_Control_View.measuring_equipment
	 */
	public function getMeasuringEquipment(){
		$notification = Cache::get('notification');
		Cache::forget('notification');
		return View::make('Quality_Control_View.measuring_equipment', array('notification'=>$notification));
	}

	public function postMeasuringEquipment(){
		$rules = array(
			"name"        =>"required"
			);
		
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails() || MeasuringEquipment::check_equipment_exist(Input::get('name'))) {
			echo "Validator fails";
		} else {
			$equipment              = New MeasuringEquipment();
			$equipment->name        = Input::get('name');
			$equipment->description = Input::get('description');
			$equipment->save();

			$notification = new Notification;
			$notification->set('success', 'Equipment has been created successful');

			Cache::put('notification', $notification, 10);

			return Redirect::to('quality-control/measuring-equipment');
		}
	}

	/**
	 * Delete Measuring Equipment
	 * @return Redirect Measuring-equipment
	 */
	public function postDeleteEquipment(){
		$equipment_id = Input::get('equipment_id');
		if (MeasuringEquipment::find($equipment_id)) {
			MeasuringEquipment::find($equipment_id)->delete();
			
			$notification = new Notification;
			$notification->set('success', 'Equipment has been deleted successful');

			
		} else {
			$notification = new Notification;
			$notification->set('danger', 'Equipment can not be deleted!!');
		}
		
		Cache::put('notification', $notification, 10);
	}

	/**
	 * New Daily Report
	 * @return View of new daily report
	 */
	public function getNewDailyReport(){

		$notification = Cache::get('notification');
		$data = array(
			"notification" => $notification
			);
		Cache::forget('notification');
		Cache::forget('calibrations');
		Cache::forget('inspectionDetailTable');

		return View::make('Quality_Control_View.new_daily_report', $data);
	}

	/**
	 * New Daily Report Submit
	 * @return Update database
	 */
	public function postNewDailyReport(){
		
		$product_id  = Input::get('product_id');

		if (!Cache::has('inspectionDetailTable') && !Cache::has('calibrations')) {
			$notification = new Notification;
			$notification->set('danger', 'Not enough data to save!!');
			Cache::put('notification', $notification, 10);
			return Redirect::to('quality-control/new-daily-report');
		} else {

			// Create new Report with Inspections and Calibrations table
			$report                       = new Report;
			$report->product_id           = Input::get('product_id');
			$report->date                 = Input::get('date');
			$report->judgement            = Input::get('judgement');
			$report->app_staff_id         = Input::get('app_staff_id');
			$report->measurement_staff_id = Input::get('measurement_staff_id');
			$report->part_no              = Input::get('part_no');
			$report->part_name            = Input::get('part_name');
			$report->lot_no               = Input::get('lot_no');
			$report->delivery_date        = Input::get('delivery_date');
			$report->sample_qty           = Input::get('sample_qty');
			$report->total_qty            = Input::get('total_qty');
			$report->inspection_qty       = Input::get('inspection_qty');
			$report->judgement_grade      = Input::get('judgement_grade');
			$report->judgement_color      = Input::get('judgement_color');
			
			$report->save();

			$reportId = $report->id;


			if (Cache::has('calibrations')) {
				$calibrations = Cache::get('calibrations');
				foreach ($calibrations as $calibration) {
					$calib = $calibration;
					$calib->report_id = $reportId;
					$calib->save();
				}
			}

			if (Cache::has('inspectionDetailTable')) {
				$inspections  = Cache::get('inspectionDetailTable');
				foreach ($inspections as $inspection) {
					$inspec = new Inspection;
					$inspec->report_id = $reportId;
					
					$inspec->save();
					$inspecID = $inspec->id;

					foreach ($inspection as $inspectionDetail) {
						$inspectDetail = $inspectionDetail;
						$inspectDetail->inspection_id = $inspecID;
						$inspectDetail->save();
					}
					
				}
			}

			Cache::forget('inspectionDetailTable');
			Cache::forget('calibrations');

			$notification = new Notification;
			$notification->set('success', 'Report save successful!!');
			Cache::put('notification', $notification, 10);
			return Redirect::to('quality-control/new-daily-report');
		}
	}


	/**
	 * New Inspection Detail modal
	 * @return form new Inspection detail
	 */
	public function postInspectionModal(){
		$product_id = Input::get('product_id');
		$cav_key    = Input::get('cav_key');
		$product    = Product::find($product_id);

		$inspectionDetailTable = Cache::get('inspectionDetailTable');


		if (!isset($inspectionDetailTable[$cav_key])) {
			return View::make('Quality_Control_View.inspection_table', array('product'=>$product, 'cav_key'=>$cav_key));
			
		} else {
			// return Response::json('error', 400);
			$inspectionDetails = $inspectionDetailTable[$cav_key];
			return View::make('Quality_Control_View.inspection_modify_table', array('inspectionDetails'=>$inspectionDetails, 'cav_key'=>$cav_key));
		}

		
	}

	/**
	 * new Inspection to Cache
	 * @return Cache array
	 */
	public function postNewInspectionDetail(){
		
		$cav_key         = Input::get('cav_key');

		$no              = count(Input::get('product_att_id'));
		$product_att_ids = Input::get('product_att_id');
		$values          = Input::get('value');
		$items           = Input::get('item');
		$equipment_ids   = Input::get('equipment_id');

		$inspectionDetails = array();

		for ($i=0; $i < $no; $i++) { 
			$inspectionDetail                 = new InspectionDetail;
			$inspectionDetail->product_att_id = $product_att_ids[$i];
			$inspectionDetail->value          = $values[$i];
			$inspectionDetail->item           = $items[$i];
			$inspectionDetail->equipment_id   = $equipment_ids[$i];

			$inspectionDetails[] = $inspectionDetail;
		}

		if (Cache::has('inspectionDetailTable')) {
			$inspectionDetailTable = Cache::get('inspectionDetailTable');
		} else $inspectionDetailTable = array();
		$inspectionDetailTable[$cav_key] = $inspectionDetails;
		Cache::put('inspectionDetailTable', $inspectionDetailTable, 720);

		return View::make('QUality_Control_View.inspection_detail_table');
		
	}

	/**
	 * Delete Inspection Button handle
	 * @return void
	 */
	public function postInspectionsDetailHandle(){
		$key  = Input::get('key');
		$type = Input::get('type');
		$inspectionDetailTable = Cache::get('inspectionDetailTable');

		if ($type == 1) {

			unset($inspectionDetailTable[$key]);
			if (count($inspectionDetailTable)) {
					Cache::put('inspectionDetailTable', $inspectionDetailTable, 720);
				} else Cache::forget('inspectionDetailTable');
			return View::make('Quality_Control_View.inspection_detail_table');

		} elseif ($type == 2) {
			$inspectionDetails = $inspectionDetailTable[$key];
			return View::make('Quality_Control_View.inspection_modify_table', array('inspectionDetails'=>$inspectionDetails, 'key'=>$key));
		}

	}

	/**
	 * Modify Inspection to Cache
	 * @return Cache array
	 */
	public function postModifyInspectionDetail(){

		$cav_key         = Input::get('cav_key');
		
		$no              = count(Input::get('product_att_id'));
		$product_att_ids = Input::get('product_att_id');
		$values          = Input::get('value');
		$items           = Input::get('item');
		$equipment_ids   = Input::get('equipment_id');

		$inspectionDetails = array();

		for ($i=0; $i < $no; $i++) { 
			$inspectionDetail                 = new InspectionDetail;
			$inspectionDetail->product_att_id = $product_att_ids[$i];
			$inspectionDetail->value          = $values[$i];
			$inspectionDetail->item           = $items[$i];
			$inspectionDetail->equipment_id   = $equipment_ids[$i];

			$inspectionDetails[] = $inspectionDetail;
		}

		
		$inspectionDetailTable = Cache::get('inspectionDetailTable');
		$inspectionDetailTable[$cav_key] = $inspectionDetails;
		
		Cache::put('inspectionDetailTable', $inspectionDetailTable, 720);

		return View::make('QUality_Control_View.inspection_detail_table');
		
	}

	/**
	 * Create new Calibration Equipment table
	 * @return [type] [description]
	 */
	public function postCalibrationEquipments() {
		
		$equipment_id = Input::get('equipment_id');
		$validator = Validator::make(Input::all(), array('equipment_id'=>"required|integer|min:1"));
		
		if ($validator->fails()) {
			return "Validator fails";
		} else {

			$calibration = new Calibration;
			$calibration->equipment_id = $equipment_id;
			if (Input::get('before_inspection')) $calibration->before_inspection = Input::get('before_inspection');
			if (Input::get('after_inspection')) $calibration->after_inspection = Input::get('after_inspection');

			if (Cache::has('calibrations')) {
				$calibrations = Cache::get('calibrations');
			} else $calibrations = array();
			$calibrations[] = $calibration;
			Cache::put('calibrations', $calibrations, 720);

			return View::make('Quality_Control_View.calibration_equipments');

		}
	}

	/**
	 * Handle equipment
	 * @return Ajax View
	 */
	public function postHandleEquipments(){
		$type         = Input::get('type');
		$key          = Input::get('key');
		$calibrations = Cache::get('calibrations');
		if ($type==1) {
			
			unset($calibrations[$key]);

		} elseif ($type==2) {
			$before_inspection = Input::get('before_inspection');
			$calibrations[$key]->before_inspection = $before_inspection;

		} elseif ($type==3) {
			$after_inspection = Input::get('after_inspection');
			$calibrations[$key]->after_inspection = $after_inspection;
		}

		if (count($calibrations)) {
			Cache::put('calibrations', $calibrations, 720);
		} else Cache::forget('calibrations');

		return View::make('Quality_Control_View.calibration_equipments');
	}

	/**
	 * Manage Daily Report
	 * @return View manage
	 */
	public function getManageDailyReport(){
		$notification = Cache::get('notification');
		Cache::forget('notification');
		Cache::forget('calibrations');
		Cache::forget('inspectionDetailTable');
		return View::make('Quality_Control_View.manage_daily_report', array('notification'=>$notification));
	}

	/**
	 * ajax for manage-daily-report
	 * @return Ajax View
	 */
	public function postManageDailyReport(){
		$from_day = Input::get('from_day');
		$to_day   = Input::get('to_day');

		$reports = Report::whereBetween('date', array($from_day, $to_day))->orderBy('date', 'asc')->get();

		Cache::forget('calibrations');
		Cache::forget('inspections');

		return View::make('Quality_Control_View.manage_report_table', array('reports'=>$reports));
	}

	/**
	 * Delete Report
	 * @return update database
	 */
	public function postDeleteReport(){

		$report_id = Input::get('report_id');
		
		$report    = Report::find($report_id);
		
		Calibration::where('report_id', '=', $report_id)->delete();
		// if (count($report->calibration)) {
		// 	foreach ($report->cablibration as $calibration) {
		// 		$calibration->delete();
		// 	}
		// }

		if (count($report->inspection)) {
			foreach ($report->inspection as $inspection) {
				$inspection->delete();
			}
		}
		// Inspection::where('report_id', '=', $report_id)->delete();
		
		$report->delete();

		return Redirect::to('quality-control/manage-daily-report');
		
	}

	/**
	 * Modify Daily Report
	 * @return View modify view
	 */
	public function getModifyReport($report_id){

		$report = Report::find($report_id);

		$calibrations = $report->calibration;
		$inspections  = $report->inspection;
		$inspectionDetailTable = array();

		foreach ($inspections as $inspection) {
			$inspectionArray = array();
			foreach ($inspection->inspectionDetail as $inspectionDetail) {
				$inspectionArray[] = $inspectionDetail;
			}
			$inspectionDetailTable[] = $inspectionArray;
		}

		Cache::put('calibrations', $calibrations, 720);
		Cache::put('inspectionDetailTable', $inspectionDetailTable , 720);

		$notification = Cache::get('notification');
		Cache::forget('notification');

		$data = array('report'=>$report, 'notification'=>$notification);

		return View::make('Quality_Control_View.modify_daily_report', $data);


	}

	/**
	 * Modify Report Submit
	 * @param  integer $report_id Report ID
	 * @return update            database
	 */
	public function postModifyReport($report_id){

		$product_id  = Input::get('product_id');

		if (!Cache::has('inspectionDetailTable') && !Cache::has('calibrations')) {
			$notification = new Notification;
			$notification->set('danger', 'Not enough data to save!!');
			Cache::put('notification', $notification, 10);
			return Redirect::to('quality-control/modify-report/'.$report_id);
		} else {

			// Delete old data of Calibration
			Calibration::where('report_id', '=', $report_id)->delete();

			// Delete old data of Inspection
			$report = Report::find($report_id);

			$inspections = $report->inspection;
			foreach ($inspections as $inspection) {
				$inspection->delete();
			}

			// Modify Report with Inspections and Calibrations table

			$report->product_id           = Input::get('product_id');
			$report->product_id           = Input::get('product_id');
			$report->date                 = Input::get('date');
			$report->judgement            = Input::get('judgement');
			$report->app_staff_id         = Input::get('app_staff_id');
			$report->measurement_staff_id = Input::get('measurement_staff_id');
			$report->part_no              = Input::get('part_no');
			$report->part_name            = Input::get('part_name');
			$report->lot_no               = Input::get('lot_no');
			$report->delivery_date        = Input::get('delivery_date');
			$report->sample_qty           = Input::get('sample_qty');
			$report->total_qty            = Input::get('total_qty');
			$report->inspection_qty       = Input::get('inspection_qty');
			$report->judgement_grade      = Input::get('judgement_grade');
			$report->judgement_color      = Input::get('judgement_color');
			
			$report->save();

			

			if (Cache::has('calibrations')) {
				$calibrations = Cache::get('calibrations');
				foreach ($calibrations as $calibration) {
					$calib                    = new Calibration;
					$calib->report_id         = $report_id;
					$calib->equipment_id      = $calibration->equipment_id;
					$calib->before_inspection = $calibration->before_inspection;
					$calib->after_inspection  = $calibration->after_inspection;
					$calib->save();
				}
			}

			if (Cache::has('inspectionDetailTable')) {
				$inspections  = Cache::get('inspectionDetailTable');
				foreach ($inspections as $inspection) {
					$inspec = new Inspection;
					$inspec->report_id = $report_id;
					
					$inspec->save();
					$inspecID = $inspec->id;

					foreach ($inspection as $inspectionDetail) {
						$inspectDetail = new InspectionDetail;
						$inspectDetail->inspection_id  = $inspecID;
						$inspectDetail->product_att_id = $inspectionDetail->product_att_id;
						$inspectDetail->value          = $inspectionDetail->value;
						$inspectDetail->item           = $inspectionDetail->item;
						$inspectDetail->equipment_id   = $inspectionDetail->equipment_id;
						$inspectDetail->save();
					}
					
				}
			}

			Cache::forget('inspectionDetailTable');
			Cache::forget('calibrations');

			$notification = new Notification;
			$notification->set('success', 'Report save successful!!');
			Cache::put('notification', $notification, 10);
			return Redirect::to('quality-control/modify-report/'.$report_id);
		}
	}

	/**
	 * Product List page
	 * @return View Quality_Control_View.product
	 */
	public function getProductList(){
		$notification = Cache::get('notification');
		Cache::forget('notification');
		return View::make('Quality_Control_View.product', array('notification'=>$notification));
	}

	/**
	 * Create New Product
	 * @return Update database
	 */
	public function postProductList(){
		$product = new Product;
		$product->name        = Input::get('name');
		$product->description = Input::get('description');
		$product->save();
		$notification = new Notification;
		$notification->set('success', 'Product has been created successful!!');
		Cache::put('notification', $notification, 10);
		return Redirect::to('quality-control/product-list');
	}

	/**
	 * Delete Product from ajax
	 * @return Update database
	 */
	public function postDeleteProduct(){
		$product_id = Input::get('product_id');
		if (Product::find($product_id)) {
			Product::find($product_id)->delete();
			
			$notification = new Notification;
			$notification->set('success', 'Equipment has been deleted successful');

			
		} else {
			$notification = new Notification;
			$notification->set('danger', 'Equipment can not be deleted!!');
		}
		
		Cache::put('notification', $notification, 10);
	}

	/**
	 * Manage Product Attribute
	 * @return View QUality_Control_View.product_attributes
	 */
	public function getProductAttributes(){
		$notification = Cache::get('notification');
		Cache::forget('notification');
		return View::make('Quality_Control_View.product_attributes', array('notification'=>$notification));
	}

	/**
	 * Produc Attribute create new
	 * @return update database
	 */
	public function postProductAttributes(){
		$product_att           = new ProductAtt;
		$product_att->name     = Input::get('name');
		$product_att->type     = Input::get('type');
		$product_att->order_no = Input::get('order_no');
		$product_att->save();
		$notification = new Notification;
		$notification->set('success', 'Product Attribute has been created successful!!');
		Cache::put('notification', $notification, 10);
		return Redirect::to('quality-control/product-attributes');
	}

	/**
	 * Delete Product Attribute from ajax
	 * @return Update database
	 */
	public function postDeleteProductAttribute(){
		$product_att_id = Input::get('product_att_id');
		if (ProductAtt::find($product_att_id)) {
			ProductAtt::find($product_att_id)->delete();
			
			$notification = new Notification;
			$notification->set('success', 'Product attribute has been deleted successful');

			
		} else {
			$notification = new Notification;
			$notification->set('danger', 'Product attribute can not be deleted!!');
		}
		
		Cache::put('notification', $notification, 10);
	}

	/**
	 * Pass Product Attribute to models ajax
	 * @return Model update databse
	 */
	public function postModifyProductAttribute(){
		$product_att_id = Input::get('product_att_id');
		$productAtt     = ProductAtt::find($product_att_id);
		return View::make('QUality_Control_View.product_attribute_modify', array('productAtt'=>$productAtt));
	}

	public function postConfirmProductModifyAttribute($product_att_id){
		
		$product_att           = ProductAtt::find($product_att_id);
		$product_att->name     = Input::get('name');
		$product_att->type     = Input::get('type');
		$product_att->order_no = Input::get('order_no');
		$product_att->save();

		return Redirect::to('quality-control/product-attributes');
	}


	/**
	 * Product Reference
	 * @param  integer $product_id Product ID
	 * @return View             
	 */
	public function getProductReference($product_id){
		$re_show      = ProductRef::where('product_id', '=', $product_id)->get();
		$product      = Product::find($product_id);
		$data = array(
			"product"      => $product,
			're_show'      => $re_show
			);
		return View::make('Quality_Control_View.product_reference', $data);
	}

	public function postProductReference($product_id){
		$product_atts = (Input::get('attribute'));
		if ($product_atts) {
			$product = Product::find($product_id);
			foreach ($product->productRef as $delProductRef) {
				if ($delProductRef->toolRef) $delProductRef->toolRef->delete();
				if ($delProductRef) $delProductRef->delete();
			}
			// ProductRef::where('product_id', '=', $product_id)->delete();
			foreach ($product_atts as $attribute_id) {
				$productRef                 = new ProductRef;
				$productRef->product_id     = $product_id;
				$productRef->product_att_id = $attribute_id;
				$productRef->save();
			}
			$notification = new Notification;
			$notification->set('success', 'Product references has been updated successful');
			Cache::put('notification', $notification, 10);
			return Redirect::to('quality-control/product-list');
		} else echo "Update is not successful!!";
	}

	/**
	 * Tool Reference page
	 * @param  integer $product_id Product ID
	 * @return View            
	 */
	public function getToolReference($product_id) {
		$product = Product::find($product_id);
		$productRefs = ProductRef::join('product_atts', 'product_atts.id', '=', 'product_refs.product_att_id')
						->select('product_refs.id', 'name')
						->where('product_id', '=', $product_id)
						->orderBy('order_no', 'asc')
						->get();

		$notification = Cache::get('notification');
		Cache::forget('notification');

		$data    = array('product'=>$product, 'notification'=>$notification, 'productRefs'=>$productRefs);

		return View::make('Quality_Control_View.product_tool_reference', $data);
	}

	public function postToolReference($product_id){

		$product     = Product::find($product_id);
		foreach ($product->productRef as $productRef) {
			$toolRef = $productRef->toolRef;
			if($toolRef) $toolRef->delete();
		}

		$product_ref_ids = Input::get('product_ref_id');
		$items           = Input::get('item');
		$equipment_ids   = Input::get('equipment_id');

		$num = count($product_ref_ids);

		for ($i=0; $i < $num; $i++) {

			$toolRef  = new ToolRef();

			$toolRef->product_ref_id = $product_ref_ids[$i];
			$toolRef->item           = $items[$i];
			$toolRef->equipment_id   = $equipment_ids[$i];
			$toolRef->save();
		}

		$notification = new Notification;
		$notification->set('success', 'Tool reference  has been updated successful');
		Cache::put('notification', $notification, 10);

		return Redirect::to('quality-control/tool-reference/'.$product_id);

	}

}
