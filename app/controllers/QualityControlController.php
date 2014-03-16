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


}
