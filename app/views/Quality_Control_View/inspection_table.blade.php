@if (count(Cache::get('inspections')))
<?php $inspections = Cache::get('inspections')?>
<table class="table table-responsive table-condensed">
	<tr>
		<th class="text-center">No</th>
		<th>Staff</th>
		<th>Amount</th>
		<th class="text-center">Quality</th>
		<th>Description</th>
		<th class="text-center">Del</th>
	</tr>

	<?php 
	$no  = 0;
	$sum = 0;
	?>
	@foreach ($inspections as $key=>$inspection)
	<tr>
		<td class="text-center">{{++$no}}</td>
		<td>{{$inspection->user->name}}</td>
		<td>{{number_format($inspection->amount, 0, '.', ',')}}</td>
		<td class="text-center">@if ($inspection->quality) OK @else NG @endif</td>
		<td>{{$inspection->description}}</td>
		<td class="text-center"><button class="btn btn-link del_button" id="{{$key}}" type="button">Del</button></td>
	</tr>
	<?php $sum+=$inspection->amount; ?>
	@endforeach
	<tr>
		<td class="text-center" colspan="2"><strong>Sumary</strong></td>
		<td><strong>{{number_format($sum, 0, '.', ',')}}</strong></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	
	
</table>

<style type="text/css">
	td {
		vertical-align: middle!important;
	}
</style>

<script>
	// Delete inspection button
	$('.del_button').click(function(){
		key = $(this).attr('id');
		$.ajax({
				url: '{{Asset("quality-control/inspections-handle")}}',
				type: 'post',
				data: {key: key},
				success: function (data) {
					$('#inspection_table').html(data);
				}
			});
	});
</script>
@endif