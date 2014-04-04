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
					<input type="hidden" name="key" value="{{$key}}">
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
					$('#inspection-result-table').html(data);
					$('#modify-inspection-modal').modal('hide')
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
	$('#productAttM-5').valid();
	

	$( "input#productAttM-6" ).rules( "add", {
		min:4.2,
		max:4.4,
		messages: {
			min: "OK value: 4.2-4.4",
			max: "OK value: 4.2-4.4"
		}
	});
	$('#productAttM-6').valid();


	
</script>
