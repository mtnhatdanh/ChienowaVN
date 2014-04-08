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
<input type="hidden" id="OK-input" value="OK">

<script>

	$( "input#productAtt-5" ).rules( "add", {
		min:9.9,
		max:10,
		messages: {
			min: "OK value: 9.9-10",
			max: "OK value: 9.9-10"
		}
	});
	$( "input#productAtt-6" ).rules( "add", {
		min:4.2,
		max:4.4,
		messages: {
			min: "OK value: 4.2-4.4",
			max: "OK value: 4.2-4.4"
		}
	});
	$( "input#productAtt-7" ).rules( "add", {
		min:4.2,
		max:4.4,
		messages: {
			min: "OK value: 4.2-4.4",
			max: "OK value: 4.2-4.4"
		}
	});
	$( "input#productAtt-8" ).rules( "add", {
		min:19.85,
		max:20.15,
		messages: {
			min: "OK value: 19.85-20.15",
			max: "OK value: 19.85-20.15"
		}
	});
	$( "input#productAtt-9" ).rules( "add", {
		min:3.4,
		max:3.6,
		messages: {
			min: "OK value: 3.4-3.6",
			max: "OK value: 3.4-3.6"
		}
	});
	$( "input#productAtt-10" ).rules( "add", {
		min:4,
		max:4.1,
		messages: {
			min: "OK value: 4-4.1",
			max: "OK value: 4-4.1"
		}
	});
	$( "input#productAtt-20" ).rules( "add", {
		min:4,
		max:4.1,
		messages: {
			min: "OK value: 4-4.1",
			max: "OK value: 4-4.1"
		}
	});
	$( "input#productAtt-22" ).rules( "add", {
		min:4,
		max:4.1,
		messages: {
			min: "OK value: 4-4.1",
			max: "OK value: 4-4.1"
		}
	});
	$( "input#productAtt-23" ).rules( "add", {
		equalTo: "#OK-input",
		messages: {
			equalTo: "OK value: OK"
		}
	});
	$( "input#productAtt-24" ).rules( "add", {
		min:27,
		max:27.15,
		messages: {
			min: "OK value: 27-27.15",
			max: "OK value: 27-27.15"
		}
	});
	$( "input#productAtt-25" ).rules( "add", {
		min:27,
		max:27.15,
		messages: {
			min: "OK value: 27-27.15",
			max: "OK value: 27-27.15"
		}
	});
	$( "input#productAtt-26" ).rules( "add", {
		min:27,
		max:27.15,
		messages: {
			min: "OK value: 27-27.15",
			max: "OK value: 27-27.15"
		}
	});
	$( "input#productAtt-27" ).rules( "add", {
		min:31.65,
		max:31.8,
		messages: {
			min: "OK value: 31.65-31.8",
			max: "OK value: 31.65-31.8"
		}
	});
	$( "input#productAtt-28" ).rules( "add", {
		min:31.65,
		max:31.8,
		messages: {
			min: "OK value: 31.65-31.8",
			max: "OK value: 31.65-31.8"
		}
	});
	$( "input#productAtt-29" ).rules( "add", {
		min:31.65,
		max:31.8,
		messages: {
			min: "OK value: 31.65-31.8",
			max: "OK value: 31.65-31.8"
		}
	});
	$( "input#productAtt-14" ).rules( "add", {
		equalTo: "#OK-input",
		messages: {
			equalTo: "OK value: OK"
		}
	});
	$( "input#productAtt-15" ).rules( "add", {
		equalTo: "#OK-input",
		messages: {
			equalTo: "OK value: OK"
		}
	});
	$( "input#productAtt-16" ).rules( "add", {
		min:8.8,
		max:9,
		messages: {
			min: "OK value: 8.8-9",
			max: "OK value: 8.8-9"
		}
	});
	$( "input#productAtt-30" ).rules( "add", {
		min:8.8,
		max:9,
		messages: {
			min: "OK value: 8.8-9",
			max: "OK value: 8.8-9"
		}
	});
	$( "input#productAtt-31" ).rules( "add", {
		min:8.8,
		max:9,
		messages: {
			min: "OK value: 8.8-9",
			max: "OK value: 8.8-9"
		}
	});
	$( "input#productAtt-34" ).rules( "add", {
		min:8.8,
		max:9,
		messages: {
			min: "OK value: 8.8-9",
			max: "OK value: 8.8-9"
		}
	});
	$( "input#productAtt-35" ).rules( "add", {
		min:8.8,
		max:9,
		messages: {
			min: "OK value: 8.8-9",
			max: "OK value: 8.8-9"
		}
	});
	$( "input#productAtt-36" ).rules( "add", {
		min:8.8,
		max:9,
		messages: {
			min: "OK value: 8.8-9",
			max: "OK value: 8.8-9"
		}
	});
	$( "input#productAtt-32" ).rules( "add", {
		equalTo: "#OK-input",
		messages: {
			equalTo: "OK value: OK"
		}
	});
	$( "input#productAtt-37" ).rules( "add", {
		equalTo: "#OK-input",
		messages: {
			equalTo: "OK value: OK"
		}
	});
	$( "input#productAtt-19" ).rules( "add", {
		min:19.5,
		max:20.5,
		messages: {
			min: "OK value: 19.5-20.5",
			max: "OK value: 19.5-20.5"
		}
	});
	
</script>