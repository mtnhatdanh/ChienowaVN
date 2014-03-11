<div class="row">
	<div class="col-sm-12">
		<table class="table table-responsive table-condensed" style="border:none">
			<tr>
				<th style="border:none">Category:</th>
				<td style="border:none">{{ucfirst(Item::find($item_id)->category->name)}}</td>
			</tr>
			@foreach ($itematts as $itematt)
			<tr>
				<th style="border:none">{{Attribute::find($itematt->attribute_id)->name}}:</th>
				<td style="border:none">{{$itematt->value}}</td>
			</tr>
			@endforeach
		</table>
	</div>
</div>