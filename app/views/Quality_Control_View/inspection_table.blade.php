<div class="row">
	<div class="col-sm-12">
		<table class="table table-responsive table-condensed table-bordered">
			<tr>
				<th>Standard tolerance</th>
				<th>Value Test</th>
				<th class="text-center">Item</th>
				<th>Inspection tool</th>
			</tr>
			<?php $no=0; ?>
			@foreach ($product->productRef as $productRef)
			<tr>
				<td>{{$productRef->productAtt->name}}<input type="hidden" name="product_att_id[]" value="{{$productRef->product_att_id}}"></td>
				<td><input type="text" name="value[{{$no}}]" id="productAtt-{{$productRef->product_att_id}}" class="form-control"></td>
				<td class="text-center">{{$productRef->toolRef->item}}<input type="hidden" name="item[]" value="{{$productRef->toolRef->item}}" /></td>
				<td>{{$productRef->toolRef->equipment->name}}<input type="hidden" name="equipment_id[]" value="{{$productRef->toolRef->equipment_id}}"></td>
			</tr>
			<?php $no++; ?>
			@endforeach
		</table>
	</div>
</div>

<script>

	$( "input#productAtt-5" ).rules( "add", {
		min:9.9,
		max:10,
		messages: {
			min: "OK value is betwwen 9.9-10",
			max: "OK value is betwwen 9.9-10"
		}
	});
	$( "input#productAtt-6" ).rules( "add", {
		min:4.2,
		max:4.4
	});

	
</script>