<style type="text/css">
	td {
		vertical-align: middle!important;
	}
	th {
		text-align: center;
	}
</style>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-responsive table-condensed table-bordered">
			<tr>
				<th>Report No</th>
				<th>Date</th>
				<th>Product</th>
				<th>JUDGEMENT</th>
				<th>Shot times</th>
				<th>Equipments Used</th>
				<th>APP'D Staff</th>
				<th>Measurement Staff</th>
				<th>Print</th>
			</tr>
			<?php $sumShot = 0;?>
			@foreach ($reports as $report)
			<tr>
				<td class="text-center">{{$report->id}}</td>
				<td class="text-center">{{date('m/d/Y', strtotime($report->date))}}</td>
				<td class="text-center">{{$report->product->name}}</td>
				<td class="text-center">@if ($report->judgement == 1) OK @else NG @endif</td>
				<td class="text-center">{{$report->countInspection()}}</td>
				<td class="text-center">{{$report->countEquipment()}}</td>
				<td>{{$report->appStaff->name}}</td>
				<td>{{$report->measurementStaff->name}}</td>
				<td class="text-center">
					<button type="button" class="btn btn-link print_report_button" id="{{$report->id}}"><span class="glyphicon glyphicon-print"></span> Report</button>
					<button type="button" class="btn btn-link print_calibration_button" id="{{$report->id}}"><span class="glyphicon glyphicon-print"></span> Calib Equipment</button>
				</td>
			</tr>
			<?php $sumShot+=$report->countInspection();?>
			@endforeach
			<tr>
				<td colspan="4"></td>
				<td class="text-center"><strong>{{$sumShot}}</strong></td>
				<td colspan="4"></td>
			</tr>
		</table>
	</div>
</div>

<script>
	$('.print_report_button').click(function(){
		report_id = $(this).attr('id');
		$.ajax({
				url: '{{Asset('data/print-quality-report')}}',
				type: 'post',
				data: {report_id: report_id},
				success: function (data) {
					$('#print_div').html(data);
					window.print();
				}
			});
	});

	$('.print_calibration_button').click(function(){
		report_id = $(this).attr('id');
		$.ajax({
				url: '{{Asset('data/print-calibrations')}}',
				type: 'post',
				data: {report_id: report_id},
				success: function (data) {
					$('#print_div').html(data);
					window.print();
				}
			});
	});
</script>
