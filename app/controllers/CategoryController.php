<?php
/**
* CategoryController Class
*/
class CategoryController extends Controller
{


	public function __construct(){
		Session::put('active_menu', 'inventory');
	}

	public function getIndex(){
		return $this->getManageCategory();
	}

	public function getManageCategory(){
		$data = array('categories'=>Category::get());
		return View::make('category', $data);
	}

	public function getReference($category_id){
		$re_show = Reference::where('category_id', '=', $category_id)->get();
		$data = array(
			"category_id" =>$category_id,
			're_show'     =>$re_show
			);
		return View::make('reference', $data);
	}

	public function postReference($category_id){
		$attributes = (Input::get('attribute'));
		if ($attributes) {
			Reference::where('category_id', '=', $category_id)->delete();
			foreach ($attributes as $attribute_id) {
				$reference = new Reference;
				$reference->category_id = $category_id;
				$reference->attribute_id = $attribute_id;
				$reference->save();
			}
			return Redirect::to('category');
		} else echo "Update is not successful!!";
	}

	public function getManageItem($category_name){
		$category = Category::where('name', '=', $category_name)->get()->first();
		$items    = Item::where('category_id', '=', $category->id)->get();
		$data     = array(
			'category' =>$category,
			'items'    =>$items
			);
		return View::make('Item_View.manage', $data);
	}

}
