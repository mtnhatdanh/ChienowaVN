<form id="new-inspection-form" action="" method="post">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title">New Inspection</h4>
	</div>
	<div class="modal-body">
		{{Former::hidden('cav_key')->value($cav_key)}}
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
						<td class="text-center">
							@if ($productRef->productAtt->type == 'boolean')
							<label class="radio-inline">
								<input class="EntTab" type="radio" name="value[{{$no}}]" value="OK" checked>OK
							</label>
							<label class="radio-inline">
								<input class="EntTab" type="radio" name="value[{{$no}}]" value="NG">NG
							</label>
							@else
							<input type="text" name="value[{{$no}}]" id="productAtt-{{$productRef->product_att_id}}" class="form-control EntTab">
							@endif
						</td>
						<td class="text-center">{{$productRef->toolRef->item}}<input type="hidden" name="item[]" value="{{$productRef->toolRef->item}}" /></td>
						<td>{{$productRef->toolRef->equipment->name}}<input type="hidden" name="equipment_id[]" value="{{$productRef->toolRef->equipment_id}}"></td>
					</tr>
					<?php $no++; ?>
					@endforeach
				</table>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary">Save Inspection</button>
		<button type="button" class="btn btn-default" data-dismiss="modal" id="inspection-modal-close">Close</button>
	</div>
</form>

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

	// submitform
	$('#new-inspection-form').validate({
		onsubmit:false
	});

	
	$('#new-inspection-form').submit(function(event){
		event.preventDefault();
		$.ajax({
				url: '{{Asset('quality-control/new-inspection-detail')}}',
				type: 'post',
				data: $('#new-inspection-form').serialize(),
				success: function (data) {
					$('#inspection-modal').modal('hide');
					$('#inspection-result-table').html(data);
				}
			});
	});

	
	// Validate value input
	<?php
	$validTableA = Config::get('validInspection.validTableA');
	?>
	@foreach ($validTableA as $productAtt_id=>$validArray)
	$( "input#productAtt-{{$productAtt_id}}" ).rules( "add", {
		min:{{$validArray['min']}},
		max:{{$validArray['max']}},
		messages: {
			min: "OK value: {{$validArray['min']}}-{{$validArray['max']}}",
			max: "OK value: {{$validArray['min']}}-{{$validArray['max']}}"
		}
	});
	@endforeach
</script>