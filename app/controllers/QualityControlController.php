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
		
		if (Cache::has('report')) {
			$report = Cache::get('report');
		} else $report = new Report;

		if (Cache::has('inspections')) {
			$inspections = Cache::get('inspections');
		} else $inspections = array();

		$notification = Cache::get('notification');
		$data = array(
			"notification" => $notification,
			"report"       => $report,
			"inspections"  => $inspections
			);
		Cache::forget('notification');

		return View::make('Quality_Control_View.new_daily_report', $data);
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

			return Redirect::to('quality-control/new-daily-report');
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



		Cache::put('calibrations', $calibrations, 720);

		return View::make('Quality_Control_View.calibration_equipments');
	}
}
