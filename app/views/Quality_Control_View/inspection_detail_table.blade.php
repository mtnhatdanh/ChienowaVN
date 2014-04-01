@if(Cache::has('inspectionDetailTable'))
	<tr>
		<th class="text-center">Inspected Product</th>
		<th class="text-center">Action</th>
	</tr>
	<?php $no = 0;?>
	@if(count(Cache::get('inspectionDetailTable')))
	@foreach (Cache::get('inspectionDetailTable') as $key=>$inspectionDetail)
	<tr>
		<td class="text-center">Product NO: {{++$no}}</td>
		<td class="text-center">
			<button class="btn btn-link del-inspection-detail-button" id="{{$key}}">Del</button>
			<button class="btn btn-link modify-inspection-detail-button" id="{{$key}}" data-toggle="modal" href='#modify-inspection-modal'>Modify</button>
		</td>
	</tr>
	
	@endforeach

	<script>
	// Delete inspection detail ajax
	$('.del-inspection-detail-button').click(function(){
		key = $(this).attr('id');
	 	$.ajax({
	 			url: '{{Asset('quality-control/inspections-detail-handle')}}',
	 			type: 'post',
	 			data: {type: 1, key: key},
	 			success: function (data) {
	 				$('#inspection-result-table').html(data);
	 			}
 		});
	});

	// Modify inspection detail ajax
	$('.modify-inspection-detail-button').click(function(){
		key = $(this).attr('id');
	 	$.ajax({
	 			url: '{{Asset('quality-control/inspections-detail-handle')}}',
	 			type: 'post',
	 			data: {type: 2, key: key},
	 			success: function (data) {
	 				$('#div-modify-inspection-detail').html(data);
	 			}
 		});
	});
	</script>

	@endif
@endif