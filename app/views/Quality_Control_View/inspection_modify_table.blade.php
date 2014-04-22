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
						<td class="text-center">
							@if ($inspectionDetail->productAtt->type == 'boolean')
							<label class="radio-inline">
								<input class="EntTab" type="radio" name="value[{{$no}}]" value="OK" @if($inspectionDetail->value == 'OK') checked="checked" @endif)>OK
							</label>
							<label class="radio-inline">
								<input class="EntTab" type="radio" name="value[{{$no}}]" value="NG" @if($inspectionDetail->value == 'NG') checked="checked" @endif)>NG
							</label>
							@else
							<input type="text" name="value[{{$no}}]" id="productAttM-{{$inspectionDetail->product_att_id}}" class="form-control EntTab" value="{{$inspectionDetail->value}}">
							@endif
						</td>
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

	// Simulate tab key when enter is pressed           
	$('.EntTab').bind('keypress', function(event){
	    if(event.which === 13){
	        if(event.shiftKey){
	            $.tabPrev();
	        }
	        else{
	            $.tabNext();
	        }
	        return false;
	    }
	});


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

	// Validate value
	
	<?php
	$validTableA = Config::get('validInspection.validTableA');
	?>
	@foreach ($validTableA as $productAtt_id=>$validArray)
	$( "input#productAttM-{{$productAtt_id}}" ).rules( "add", {
		min:{{$validArray['min']}},
		max:{{$validArray['max']}},
		messages: {
			min: "OK value: {{$validArray['min']}}-{{$validArray['max']}}",
			max: "OK value: {{$validArray['min']}}-{{$validArray['max']}}"
		}
	});
	$( "input#productAttM-{{$productAtt_id}}" ).valid();
	@endforeach
	
</script>
