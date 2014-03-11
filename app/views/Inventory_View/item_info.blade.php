<div class="container">
	<div class="col-sm-2"><strong>Category:</strong></div>
	<div class="col-sm-3">{{ucfirst($item->category->name)}}</div>
</div>
@foreach ($item->itematt as $itematt)
<div class="container">
	<div class="col-sm-2"><strong>{{Attribute::find($itematt->attribute_id)->name}}:</strong></div>
	<div class="col-sm-3">{{$itematt->value}}</div>
</div>
@endforeach