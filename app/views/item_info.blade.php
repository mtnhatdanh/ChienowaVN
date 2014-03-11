<div class="container">
	<div class="col-sm-2">Category:</div>
	<div class="col-sm-4">{{ucfirst(Item::find($item_id)->category->name)}}</div>
</div>
@foreach ($itematts as $itematt)
<div class="container">
	<div class="col-sm-2">{{Attribute::find($itematt->attribute_id)->name}}:</div>
	<div class="col-sm-4">{{$itematt->value}}</div>
</div>
@endforeach