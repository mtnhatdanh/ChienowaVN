<div class="row">
	<div class="col-sm-12">
		<table class="table table-responsive table-condensed table-bordered">
			<tr>
				<th>Standard tolerance</th>
				<th>Value Test</th>
				<th class="text-center">Item</th>
				<th>Inspection tool</th>
			</tr>
			<input type="hidden" name="key" value="{{$key}}">
			@foreach ($inspectionDetails as $inspectionDetail)
			<tr>
				<td>{{$inspectionDetail->productAtt->name}}<input type="hidden" name="product_att_id[]" value="{{$inspectionDetail->product_att_id}}"></td>
				<td><input type="text" name="value[]" id="inputValue" class="form-control" value="{{$inspectionDetail->value}}"></td>
				<td class="text-center">{{$inspectionDetail->item}}<input type="hidden" name="item[]" value="{{$inspectionDetail->item}}" /></td>
				<td>{{$inspectionDetail->equipment->name}}<input type="hidden" name="equipment_id[]" value="{{$inspectionDetail->equipment_id}}"></td>
			</tr>
			@endforeach
		</table>
	</div>
</div>