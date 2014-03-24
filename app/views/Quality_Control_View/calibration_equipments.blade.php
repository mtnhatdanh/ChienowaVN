@if (count(Cache::get('calibrations')))
<style type="text/css">
	td {
		vertical-align: middle!important;
	}
</style>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-responsive table-bordered table-condensed">
			<tr>
				<th class="text-center">No</th>
				<th>Equipment Name</th>
				<th>Before Inspection</th>
				<th>After Inspection</th>
				<th class="text-center">Del</th>
			</tr>
			<?php $no=0;?>
			@foreach (Cache::get('calibrations') as $key=>$calibration)
			<tr>
				<td class="text-center">{{++$no}}</td>
				<td>{{$calibration->equipment->name}}</td>
				<td>
					<input type="text" name="before_inspection" id="{{$key}}" class="form-control before_inspection" value="{{$calibration->before_inspection}}" required="required">
				</td>
				<td>
					<input type="text" name="after_inspection" id="{{$key}}" class="form-control after_inspection" value="{{$calibration->after_inspection}}" required="required">
				</td>
				<td class="text-center"><button class="btn btn-link del_equipment" id="{{$key}}">Del</button></td>
			</tr>
			@endforeach
		</table>
	</div>
</div>

<script>
	// Modify table
	$('.del_equipment').click(function(){
		key = $(this).attr('id');
		$.ajax({
				url: '{{Asset('quality-control/handle-equipments')}}',
				type: 'post',
				data: {type: 1, key: key},
				success: function (data) {
					$('#validation_table').html(data);
				}
			});
	});

	$('.before_inspection').blur(function(){
		key = $(this).attr('id');
		before_inspection = $(this).val();
		$.ajax({
				url: '{{Asset('quality-control/handle-equipments')}}',
				type: 'post',
				data: {type: 2, key: key, before_inspection: before_inspection},
				success: function (data) {
					$('#validation_table').html(data);
				}
			});
	});

	$('.after_inspection').blur(function(){
		key = $(this).attr('id');
		after_inspection = $(this).val();
		$.ajax({
				url: '{{Asset('quality-control/handle-equipments')}}',
				type: 'post',
				data: {type: 3, key: key, after_inspection: after_inspection},
				success: function (data) {
					$('#validation_table').html(data);
				}
			});
	});

</script>
@endif