<?php
/**
* ItemController Class
*/
class ItemController extends Controller
{


	public function __construct(){
		Session::put('active_menu', 'inventory');
	}

	public function getIndex(){
		return $this->getManageItem();
	}


	/**
	 * /item/create-item
	 * @return View New Item
	 */
	public function getCreateItem(){
		return View::make('Item_View.create');
	}

	/**
	 * pick category ajax
	 * @return view list att
	 */
	public function postPickCategory(){
		$category_id = Input::get('category_id');

		$references = Reference::join('attributes', 'attributes.id', '=', 'references.attribute_id')->where('category_id', '=', $category_id)->orderBy('order_no', 'asc')->get();

		// $references = Reference::with(array('attribute'=>function($query){
		// 	$query->where('order_no', '=', 100);
		// }))->where('category_id', '=', $category_id)->get()->first();


		$data        = array(
			"category_id" =>$category_id,
			"references"  =>$references
			);
		return View::make('Item_View.pick_category', $data);
	}


	/*
	take data from Create Item
	item/create-item
	 */
	public function postCreateItem(){

		$category_id       = Input::get('category');
		$item              = new Item();
		$item->category_id = $category_id;
		$item->save();
		$insertedId        = $item->id;
		
		foreach (Input::all() as $attribute_id => $value) {
			if ($attribute_id!='category') {
				$attribute_id           = (int)str_replace('Att', '', $attribute_id);
				$item_att               = new ItemAtt();
				$item_att->item_id      = $insertedId;
				$item_att->attribute_id = $attribute_id;
				$item_att->value        = $value;
				$item_att->save();
			}
		}

		return Redirect::to('category/manage-item/'.Category::find($category_id)->name);

	}


	/*
	/item/modify-item/($item_id)
	 */
	public function getModifyItem($item_id){
			$item     = Item::find($item_id);
			$itematts = ItemAtt::join('attributes', 'attributes.id', '=', 'item_atts.attribute_id')->where('item_id', '=', $item_id)->orderBy('order_no', 'asc')->get();
			$data = array(
				'item'     =>$item,
				'itematts' =>$itematts
			);
		return View::make('Item_View.modify', $data);
	}

	/*
	get post data from /item/modify-item/($item_id)
	 */
	public function postModifyItem($item_id){
		ItemAtt::where('item_id', '=', $item_id)->delete();
		
		foreach (Input::all() as $attribute_id => $value) {
			$attribute_id           = (int)str_replace('Att', '', $attribute_id);
			$item_att               = new ItemAtt();
			$item_att->item_id      = $item_id;
			$item_att->attribute_id = $attribute_id;
			$item_att->value        = $value;
			$item_att->save();
		}

		return Redirect::to('category/manage-item/'.Item::find($item_id)->category->name);
	}

}

