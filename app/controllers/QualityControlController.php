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
		Cache::forget('inspections');

		return View::make('Quality_Control_View.new_daily_report', $data);
	}

	/**
	 * New Daily Report Submit
	 * @return Update database
	 */
	public function postNewDailyReport(){
		$product_id  = Input::get('product_id');
		$date        = Input::get('date');
		$description = Input::get('description');

		if (!Cache::has('inspections') && !Cache::has('calibrations')) {
			$notification = new Notification;
			$notification->set('danger', 'Not enough data to save!!');
			Cache::put('notification', $notification, 10);
			return Redirect::to('quality-control/new-daily-report');
		} else {

			// Create new Report with Inspections and Calibrations table
			$report              = new Report;
			$report->product_id  = $product_id;
			$report->date        = $date;
			$report->description = $description;
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

			if (Cache::has('inspections')) {
				$inspections  = Cache::get('inspections');
				foreach ($inspections as $inspection) {
					$inspec = $inspection;
					$inspec->report_id = $reportId;
					$inspec->save();
				}
			}

			Cache::forget('inspections');
			Cache::forget('calibrations');

			$notification = new Notification;
			$notification->set('success', 'Report save successful!!');
			Cache::put('notification', $notification, 10);
			return Redirect::to('quality-control/new-daily-report');
		}
	}

	/**
	 * Inspection Table handle
	 * @return View Inspection table
	 */
	public function postInspectionTable(){

		$rules = array(
			"user_id"     =>"required|min:1",
			"amount"      =>"required|min:1",
			"description" => "required"
			);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return "Validator fails";
		} else {
			$inspection          = new Inspection;
			$inspection->user_id = Input::get('user_id');
			$inspection->amount  = Input::get('amount');
			if(Input::get('quality')) $inspection->quality = 1; else $inspection->quality = 0;
			$inspection->description = Input::get('description');

			if (Cache::has('inspections')) {
				$inspections = Cache::get('inspections');
			} else {
				$inspections = array();
			}
			$inspections[] = $inspection;
			Cache::put('inspections', $inspections, 720);

			return View::make('Quality_Control_View.inspection_table');
		}
	}

	/**
	 * Delete Inspection Button handle
	 * @return void
	 */
	public function postInspectionsHandle(){
		$key = Input::get('key');
		$inspections = Cache::get('inspections');
		unset($inspections[$key]);

		if (count($inspections)) {
			Cache::put('inspections', $inspections, 720);
		} else Cache::forget('inspections');

		return View::make('Quality_Control_View.inspection_table');
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
		echo $report_id;
		Calibration::where('report_id', '=', $report_id)->delete();
		Inspection::where('report_id', '=', $report_id)->delete();
		$report = Report::find($report_id);
		$report->delete();

		$notification = new Notification;
		$notification->set('success', 'Delete report has been successful!!');
		Cache::put('notification', $notification, 10);

		return Redirect::to('quality-control/manage-daily-report');
		
	}

	/**
	 * Modify Daily Report
	 * @return View modify view
	 */
	public function getModifyReport($report_id){

		$report = Report::find($report_id);

		$calibrations = $report->calibration;
		$inspections = $report->inspection;
		Cache::put('calibrations', $calibrations, 720);
		Cache::put('inspections', $inspections, 720);

		$data = array('report'=>$report);

		return View::make('Quality_Control_View.modify_daily_report', $data);


	}

	/**
	 * Modify Report Submit
	 * @param  integer $report_id Report ID
	 * @return update            database
	 */
	public function postModifyReport($report_id){

		$product_id  = Input::get('product_id');
		$date        = Input::get('date');
		$description = Input::get('description');

		if (!Cache::has('inspections') && !Cache::has('calibrations')) {
			$notification = new Notification;
			$notification->set('danger', 'Not enough data to save!!');
			Cache::put('notification', $notification, 10);
			return Redirect::to('quality-control/manage-daily-report');
		} else {

			// Update Report with Inspections and Calibrations table
			$report              = Report::find($report_id);
			$report->product_id  = $product_id;
			$report->date        = $date;
			$report->description = $description;
			$report->save();

			Calibration::where('report_id', '=', $report_id)->delete();
			Inspection::where('report_id', '=', $report_id)->delete();


			if (Cache::has('calibrations')) {
				$calibrations = Cache::get('calibrations');
				foreach ($calibrations as $calibration) {
					$calib = new Calibration;
					$calib->report_id         = $report_id;
					$calib->equipment_id      = $calibration->equipment_id;
					$calib->before_inspection = $calibration->before_inspection;
					$calib->after_inspection  = $calibration->after_inspection;
					$calib->save();
				}
			}

			if (Cache::has('inspections')) {
				$inspections  = Cache::get('inspections');
				foreach ($inspections as $inspection) {
					$inspec              = new Inspection;
					$inspec->report_id   = $report_id;
					$inspec->user_id     = $inspection->user_id;
					$inspec->amount      = $inspection->amount;
					$inspec->quality     = $inspection->quality;
					$inspec->description = $inspection->description;
					$inspec->save();
				}
			}

			Cache::forget('inspections');
			Cache::forget('calibrations');

			$notification = new Notification;
			$notification->set('success', 'Report update successful!!');
			Cache::put('notification', $notification, 10);
			return Redirect::to('quality-control/manage-daily-report');
		}
	}

}
