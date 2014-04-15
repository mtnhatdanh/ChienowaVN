<form id="modify_inspection_form" action="" method="post">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title">Modify Inspection</h4>
	</div>
	<div class="modal-body">
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
					<input type="hidden" name="cav_key" value="{{$cav_key}}">
					@foreach ($inspectionDetails as $inspectionDetail)
					<tr>
						<td>{{$inspectionDetail->productAtt->name}}<input type="hidden" name="product_att_id[]" value="{{$inspectionDetail->product_att_id}}"></td>
						<td><input type="text" name="value[{{$no}}]" id="productAttM-{{$inspectionDetail->product_att_id}}" class="form-control" value="{{$inspectionDetail->value}}"></td>
						<td class="text-center">{{$inspectionDetail->item}}<input type="hidden" name="item[]" value="{{$inspectionDetail->item}}" /></td>
						<td>{{$inspectionDetail->equipment->name}}<input type="hidden" name="equipment_id[]" value="{{$inspectionDetail->equipment_id}}"></td>
					</tr>
					<?php $no++; ?>
					@endforeach
				</table>
			</div>
		</div>

	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary">Update Inspection</button>
		<button type="button" class="btn btn-default" data-dismiss="modal" id="inspection-modal-close">Close</button>
	</div>
</form>	
<input type="hidden" id="OK-input" value="OK">
<script>
	// Modify Inspection form handle
	$('#modify_inspection_form').validate({
		onsubmit:false
	});

	$('#modify_inspection_form').submit(function(event){
		event.preventDefault();
		$.ajax({
				url: '{{Asset('quality-control/modify-inspection-detail')}}',
				type: 'post',
				data: $('#modify_inspection_form').serialize(),
				success: function (data) {
					$('#inspection-modal').modal('hide');
					$('#inspection-result-table').html(data);
				}
			});
	});



	$( "input#productAttM-5" ).rules( "add", {
		min:9.9,
		max:10,
		messages: {
			min: "OK value: 9.9-10",
			max: "OK value: 9.9-10"
		}
	});
	$( "input#productAttM-5" ).valid();

	$( "input#productAttM-6" ).rules( "add", {
		min:4.2,
		max:4.4,
		messages: {
			min: "OK value: 4.2-4.4",
			max: "OK value: 4.2-4.4"
		}
	});
	$( "input#productAttM-6" ).valid();

	$( "input#productAttM-7" ).rules( "add", {
		min:4.2,
		max:4.4,
		messages: {
			min: "OK value: 4.2-4.4",
			max: "OK value: 4.2-4.4"
		}
	});
	$( "input#productAttM-7" ).valid();

	$( "input#productAttM-8" ).rules( "add", {
		min:19.85,
		max:20.15,
		messages: {
			min: "OK value: 19.85-20.15",
			max: "OK value: 19.85-20.15"
		}
	});
	$( "input#productAttM-8" ).valid();

	$( "input#productAttM-9" ).rules( "add", {
		min:3.4,
		max:3.6,
		messages: {
			min: "OK value: 3.4-3.6",
			max: "OK value: 3.4-3.6"
		}
	});
	$( "input#productAttM-9" ).valid();

	$( "input#productAttM-10" ).rules( "add", {
		min:4,
		max:4.1,
		messages: {
			min: "OK value: 4-4.1",
			max: "OK value: 4-4.1"
		}
	});
	$( "input#productAttM-10" ).valid();

	$( "input#productAttM-20" ).rules( "add", {
		min:4,
		max:4.1,
		messages: {
			min: "OK value: 4-4.1",
			max: "OK value: 4-4.1"
		}
	});
	$( "input#productAttM-20" ).valid();

	$( "input#productAttM-22" ).rules( "add", {
		min:4,
		max:4.1,
		messages: {
			min: "OK value: 4-4.1",
			max: "OK value: 4-4.1"
		}
	});
	$( "input#productAttM-22" ).valid();

	$( "input#productAttM-23" ).rules( "add", {
		equalTo: "#OK-input",
		messages: {
			equalTo: "OK value: OK"
		}
	});
	$( "input#productAttM-23" ).valid();

	$( "input#productAttM-24" ).rules( "add", {
		min:27,
		max:27.15,
		messages: {
			min: "OK value: 27-27.15",
			max: "OK value: 27-27.15"
		}
	});
	$( "input#productAttM-24" ).valid();

	$( "input#productAttM-25" ).rules( "add", {
		min:27,
		max:27.15,
		messages: {
			min: "OK value: 27-27.15",
			max: "OK value: 27-27.15"
		}
	});
	$( "input#productAttM-25" ).valid();

	$( "input#productAttM-26" ).rules( "add", {
		min:27,
		max:27.15,
		messages: {
			min: "OK value: 27-27.15",
			max: "OK value: 27-27.15"
		}
	});
	$( "input#productAttM-26" ).valid();

	$( "input#productAttM-27" ).rules( "add", {
		min:31.65,
		max:31.8,
		messages: {
			min: "OK value: 31.65-31.8",
			max: "OK value: 31.65-31.8"
		}
	});
	$( "input#productAttM-27" ).valid();

	$( "input#productAttM-28" ).rules( "add", {
		min:31.65,
		max:31.8,
		messages: {
			min: "OK value: 31.65-31.8",
			max: "OK value: 31.65-31.8"
		}
	});
	$( "input#productAttM-28" ).valid();

	$( "input#productAttM-29" ).rules( "add", {
		min:31.65,
		max:31.8,
		messages: {
			min: "OK value: 31.65-31.8",
			max: "OK value: 31.65-31.8"
		}
	});
	$( "input#productAttM-29" ).valid();

	$( "input#productAttM-14" ).rules( "add", {
		equalTo: "#OK-input",
		messages: {
			equalTo: "OK value: OK"
		}
	});
	$( "input#productAttM-14" ).valid();

	$( "input#productAttM-15" ).rules( "add", {
		equalTo: "#OK-input",
		messages: {
			equalTo: "OK value: OK"
		}
	});
	$( "input#productAttM-15" ).valid();

	$( "input#productAttM-16" ).rules( "add", {
		min:8.8,
		max:9,
		messages: {
			min: "OK value: 8.8-9",
			max: "OK value: 8.8-9"
		}
	});
	$( "input#productAttM-16" ).valid();

	$( "input#productAttM-30" ).rules( "add", {
		min:8.8,
		max:9,
		messages: {
			min: "OK value: 8.8-9",
			max: "OK value: 8.8-9"
		}
	});
	$( "input#productAttM-30" ).valid();

	$( "input#productAttM-31" ).rules( "add", {
		min:8.8,
		max:9,
		messages: {
			min: "OK value: 8.8-9",
			max: "OK value: 8.8-9"
		}
	});
	$( "input#productAttM-31" ).valid();

	$( "input#productAttM-34" ).rules( "add", {
		min:8.8,
		max:9,
		messages: {
			min: "OK value: 8.8-9",
			max: "OK value: 8.8-9"
		}
	});
	$( "input#productAttM-34" ).valid();

	$( "input#productAttM-35" ).rules( "add", {
		min:8.8,
		max:9,
		messages: {
			min: "OK value: 8.8-9",
			max: "OK value: 8.8-9"
		}
	});
	$( "input#productAttM-35" ).valid();

	$( "input#productAttM-36" ).rules( "add", {
		min:8.8,
		max:9,
		messages: {
			min: "OK value: 8.8-9",
			max: "OK value: 8.8-9"
		}
	});
	$( "input#productAttM-36" ).valid();

	$( "input#productAttM-32" ).rules( "add", {
		equalTo: "#OK-input",
		messages: {
			equalTo: "OK value: OK"
		}
	});
	$( "input#productAttM-32" ).valid();

	$( "input#productAttM-37" ).rules( "add", {
		equalTo: "#OK-input",
		messages: {
			equalTo: "OK value: OK"
		}
	});
	$( "input#productAttM-37" ).valid();

	$( "input#productAttM-19" ).rules( "add", {
		min:19.5,
		max:20.5,
		messages: {
			min: "OK value: 19.5-20.5",
			max: "OK value: 19.5-20.5"
		}
	});
	$( "input#productAttM-19" ).valid();


	
</script>
