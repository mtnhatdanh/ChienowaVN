<?php 
$inspectionDetailTable = Cache::get('inspectionDetailTable');
?>
<tr>
	<th class="text-center">Inspection Name</th>
	<th class="text-center">Status</th>
</tr>
<tr>
	<td class="text-center"><button class="btn btn-link cav-button" id="0" data-toggle="modal" data-target="#inspection-modal">cav1</button></td>
	<td class="text-center" id="cav0">@if (isset($inspectionDetailTable[0])) <span class="label label-success">Has data</span> @else <span class="label label-danger">No data</span> @endif</td>
</tr>
<tr>
	<td class="text-center"><button class="btn btn-link cav-button" id="1" data-toggle="modal" data-target="#inspection-modal">cav1</button></td>
	<td class="text-center" id="cav1">@if (isset($inspectionDetailTable[1])) <span class="label label-success">Has data</span> @else <span class="label label-danger">No data</span> @endif</td>
</tr>
<tr>
	<td class="text-center"><button class="btn btn-link cav-button" id="2" data-toggle="modal" data-target="#inspection-modal">cav2</button></td>
	<td class="text-center" id="cav2">@if (isset($inspectionDetailTable[2])) <span class="label label-success">Has data</span> @else <span class="label label-danger">No data</span> @endif</td>
</tr>
<tr>
	<td class="text-center"><button class="btn btn-link cav-button" id="3" data-toggle="modal" data-target="#inspection-modal">cav2</button></td>
	<td class="text-center" id="cav3">@if (isset($inspectionDetailTable[3])) <span class="label label-success">Has data</span> @else <span class="label label-danger">No data</span> @endif</td>
</tr>


<script>
	// New Inspection handle
	$('button.cav-button').click(function(){
		cav_key    = $(this).attr('id');
		product_id = $('#product_id').val();
		$.ajax({
				url: '{{Asset('quality-control/inspection-modal')}}',
				type: 'post',
				data: {product_id: product_id, cav_key: cav_key},
				success: function (data) {
					$('#div_inspection_detail').html(data);
				}
			});
	});
</script>