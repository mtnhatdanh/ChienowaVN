<div class="row">
	<div class="col-sm-12">
		<table class="table table-responsive table-condensed table-bordered">
			<tr>
				<th>Standard tolerance</th>
				<th>Value Test</th>
				<th class="text-center">Item</th>
				<th>Inspection tool</th>
			</tr>
			@foreach ($product->productRef as $productRef)
			<tr>
				<td>{{$productRef->productAtt->name}}<input type="hidden" name="product_att_id[]" value="{{$productRef->product_att_id}}"></td>
				<td><input type="text" name="value[]" id="inputValue" class="form-control"></td>
				<td class="text-center">{{$productRef->toolRef->item}}<input type="hidden" name="item[]" value="{{$productRef->toolRef->item}}" /></td>
				<td>{{$productRef->toolRef->equipment->name}}<input type="hidden" name="equipment_id[]" value="{{$productRef->toolRef->equipment_id}}"></td>
			</tr>
			@endforeach
		</table>
	</div>
</div>