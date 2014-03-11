<?php
/**
* AttributeController Class
*/
class AttributeController extends Controller
{


	public function __construct(){
		Session::put('active_menu', 'inventory');
	}

	/**
	 * attribute/manage-attribute
	 * @return View Attribute_view.manage
	 */
	public function getManageAttribute(){
		$data = array('attributes'=>Attribute::orderBy('order_no', 'asc')->get());;
		return View::make('Attribute_View.manage', $data);
	}

	public function getCreateAttribute(){
		return View::make('Attribute_view.create');
	}

	public function postCreateAttribute(){
		$rules = array(
			"name"    =>"required",
			"type"    =>"required",
			"order_no" =>"required"
			);
		if (!Validator::make(Input::all(), $rules)->fails()) {
			$attribute           = new Attribute;
			$attribute->name     = Input::get('name');
			$attribute->type     = Input::get('type');
			$attribute->order_no = Input::get('order_no');
			$attribute->save();
			return Redirect::to('attribute');
		} else echo "Validator fails";
	}


	public function getIndex(){
		return $this->getManageAttribute();
	}


}
