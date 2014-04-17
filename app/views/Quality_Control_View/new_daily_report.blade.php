@extends("theme")

@section('title')
New Daily Report
@endsection

@section('content')

<?php
$report_no = DB::table('information_schema.tables')
			->select('auto_increment')
			->where('table_schema', '=', 'ChienowaVN')
			->where('table_name', '=', 'daily_reports')
			->first()
			->auto_increment;
?>

<style>
	td {
		vertical-align: middle!important;
	}
</style>
<div class="container hidden-print">
	<div class="page-header">
		<h1>New Daily Report for Quality Control</h1>
		<strong>Report No: </strong> {{$report_no}}
	</div>
	@include('notification')
</div>

<div class="container hidden-print" id="content">
	
	{{Former::rawOpen()->id('form-report')->action(asset('quality-control/new-daily-report'))}}
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading"><h3 class="panel-title">Main infomation</h3></div>
					<div class="panel-body">
						
						<div class="row form-group">
							<div class="col-sm-3">
								<label for="product_id" class="control-label">Product</label>
								<select type="product_id" class="form-control" id="product_id" name="product_id">
									@foreach (Product::get() as $product)
									<option value="{{$product->id}}">{{$product->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="col-sm-3">
								<label for="date" class="control-label">Date</label>
								<input type="date" class="form-control" id="date" name="date" value="{{date('Y-m-d')}}">
							</div>
							<div class="col-sm-3 form-group">
								<label for="judgement" class="control-label">JUDGEMENT</label>
								<select name="judgement" id="judgement" class="form-control">
									<option value="-1">-- Select --</option>
									<option value="1">OK</option>
									<option value="0">NG</option>
								</select>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3">
								<label for="app_staff_id" class="control-label">APP'D</label>
								<select name="app_staff_id" id="selectApp_staff_id" class="form-control">
									<option value="-1">-- Select a staff --</option>
									@foreach (StaffRank::get() as $staffRank)
									@if (in_array(2, explode(' ', $staffRank->skill_rank)))
									<option value="{{$staffRank->user->id}}">{{$staffRank->user->name}}</option>
									@endif
									@endforeach
								</select>
							</div>
							<div class="col-sm-3">
								<label for="measurement_staff_id" class="control-label">Measurement</label>
								<select name="measurement_staff_id" id="measurement_staff_id" class="form-control">
									<option value="-1">-- Select a staff --</option>
									@foreach (StaffRank::get() as $staffRank)
									@if (in_array(1, explode(' ', $staffRank->skill_rank)))
									<option value="{{$staffRank->user->id}}">{{$staffRank->user->name}}</option>
									@endif
									@endforeach
								</select>
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-2">
								<button class="btn btn-primary btn-block">Save Report</button>
							</div>
							<div class="col-sm-2">
								<button type="button" class="btn btn-default btn-block" id="report_print_button"><span class="glyphicon glyphicon-print"></span> Print Report</button>
							</div>
							<div class="col-sm-2">
								<button type="button" class="btn btn-success btn-block" data-toggle="modal" href='#validation-modal'>Equipments Calibration</button>
							</div>
						</div>
		
					</div>
		
					<table class="table table-responsive table-condensed table-bordered">
						<tr>
							<th class="text-center" colspan="4">GENERAL INFORMATION</th>
						</tr>
						<tr>
							<td>Part No.</td>
							<td>
								{{Former::text('part_no')->class('form-control')}}
							</td>
							<td>Part name</td>
							<td>
								{{Former::text('part_name')->class('form-control')}}
							</td>
						</tr>
						<tr>
							<td>Lot No.</td>
							<td>
								{{Former::text('lot_no')->class('form-control')}}
							</td>
							<td>Delivery Date</td>
							<td>
								{{Former::date('delivery_date')->class('form-control')}}
							</td>
						</tr>
						<tr>
							<td>Sample Quantity</td>
							<td>
								{{Former::text('sample_qty')->class('form-control')}}
							</td>
							<td>Total Quantity</td>
							<td>
								{{Former::text('total_qty')->class('form-control')}}
							</td>
						</tr>
						<tr>
							<td>Products Sent Qty</td>
							<td>
								{{Former::text('inspection_qty')->class('form-control')}}
							</td>
						</tr>
						<tr>
							<th class="text-center" colspan="4">STANDARD JUDGEMENT</th>
						</tr>
						<tr>
							<td>Judgement Grade</td>
							<td class="text-center">
								<label class="radio-inline">
									<input type="radio" name="judgement_grade" id="judgement_grade1" value="1" checked>OK
								</label>
								<label class="radio-inline">
									<input type="radio" name="judgement_grade" id="judgement_grade2" value="0">NG
								</label>
							</td>
							<td>Judgement Color</td>
							<td class="text-center">
								<label class="radio-inline">
									<input type="radio" name="judgement_color" id="judgement_color1" value="1" checked>OK
								</label>
								<label class="radio-inline">
									<input type="radio" name="judgement_color" id="judgement_color2" value="0">NG
								</label>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	{{Former::close()}}
	
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-responsive table-condensed table-bordered"  id="inspection-result-table">
				@include('Quality_Control_View.inspection_detail_table')
			</table>
	
		</div>
	</div>
</div>

<!-- Modal Calibration -->
<div class="modal fade bs-example-modal-lg hidden-print" id="validation-modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Equipments Validation</h4>
			</div>
			<div class="modal-body">
				<div class="row form-group">
					<div class="col-sm-2">
						<label for="equipment_id" class="control-label">Equipment</label>
						<select name="equipment_id" id="equipment_id" class="form-control">
							<option value="-1">-- Select --</option>
							@foreach (Equipment::get() as $equipment)
							<option value="{{$equipment->id}}">{{$equipment->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="col-sm-5">
						<label for="before_inspection">Before Inspection</label>
						<input type="text" name="before_inspection" id="inputBefore_inspection" class="form-control" required="required" placeholder="Before inspection..">
					</div>
					<div class="col-sm-5">
						<label for="after_inspection">After Inspection</label>
						<input type="text" name="after_inspection" id="inputAfter_inspection" class="form-control" required="required" placeholder="After inspection..">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-3">
						<button type="button" class="btn btn-default btn-block" id="inspection_add_button">Add to table</button>
					</div>
					<div class="col-sm-2">
						<button type="button" class="btn btn-block btn-default" id="print_calibration"><span class="glyphicon glyphicon-print"></span> Print form</button>
					</div>
				</div>

				<div id="validation_table">
					@include('Quality_Control_View.calibration_equipments')
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal New Inspection -->
<div class="modal fade bs-example-modal-lg hidden-print" id="inspection-modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			
			<div id="div_inspection_detail"></div>
				
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="visible-print" id="print_div"></div>

<script type="text/javascript">

	// validation main form
	$('#form-report').validate({
		rules:{
			date:{
				required:true,
			},
			judgement:{
				min:0,
			},
			app_staff_id:{
				min:1,
			},
			measurement_staff_id:{
				min:1,
			}
		}
	});

	// Print Daily Report
	$('#report_print_button').click(function(){
		$.ajax({
			url: '{{Asset('data/print-quality-report')}}',
			type: 'post',
			data: $('#form-report').serialize(),
			success: function (data) {
				$('#print_div').html(data);
				window.print();
			}
		});
	});

	// Calibration ajax
	$('#inspection_add_button').click(function(){
		equipment_id      = $('#equipment_id').val();
		before_inspection = $('#inputBefore_inspection').val();
		after_inspection  = $('#inputAfter_inspection').val();
		if (equipment_id < 0) {
			alert('Input is not valid!!');
		} else {
			$.ajax({
					url: '{{Asset('quality-control/calibration-equipments')}}',
					type: 'post',
					data: {equipment_id: equipment_id, before_inspection: before_inspection, after_inspection: after_inspection},
					success: function (data) {
						$('#validation_table').html(data);
						$('#equipment_id').val("-1");
						$('#inputBefore_inspection').val("");
						$('#inputAfter_inspection').val("");
					}
				});
		}
	});

	// Print Calibration Equipments
	
	$('#print_calibration').click(function(){
		date      = $('#date').val();
		report_no = {{$report_no}};
		$.ajax({
				url: '{{Asset('data/print-calibrations')}}',
				type: 'post',
				data: {date: date, report_no: report_no},
				success: function (data) {
					$('#print_div').html(data);
					window.print();
				}
			});
	});
	

</script>

@endsection