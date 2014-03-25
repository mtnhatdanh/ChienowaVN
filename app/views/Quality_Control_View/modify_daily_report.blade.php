@extends("theme")

@section('title')
Modify Daily Report
@endsection

@section('content')


<div class="container hidden-print">
	<div class="page-header">
		<h1>Modify Daily Report for Quality Control</h1>
	</div>
</div>

<div class="container hidden-print" id="content">

	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading"><h3 class="panel-title">Main infomation</h3></div>
				<div class="panel-body">
					
					<form action="{{Asset('quality-control/modify-report/'.$report->id)}}" method="post" id="form-report">
						<div class="row">
							<div class="form-group col-sm-3">
								<label for="product_id" class="control-label">Product</label>
								<select type="product_id" class="form-control" id="product_id" name="product_id">
									@foreach (Product::get() as $product)
									<option value="{{$product->id}}" @if ($report->product_id == $product->id) selected @endif>{{$product->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-sm-3">
								<label for="date" class="control-label">Date</label>
								<input type="date" class="form-control" id="date" name="date" value="{{$report->date}}">
							</div>
							<div class="form-group col-sm-6">
								<label for="description" class="control-label">Description</label>
								<input type="text" class="form-control" id="description_report" name="description" placeholder="Description.." value="{{$report->description}}">
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
							<div class="col-sm-3">
								<a href="{{Asset('quality-control/manage-daily-report')}}"><button type="button" class="btn btn-default btn-block">Back to Manage Reports</button></a>
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
	
	<form action="" method="post" id="form-register">
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading"><h3 class="panel-title">Inspection Report</h3></div>
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-3 form-group">
								<label for="user_id" class="control-label">Staff</label>
								<select name="user_id" id="user_id" class="form-control">
									<option value="-1">-- Select a staff --</option>
									@foreach (User::where('id', '!=', 16)->get() as $user)
									<option value="{{$user->id}}">{{$user->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="col-sm-2 form-group">
								<label for="inputAmount" class="control-label">Amount</label>
								<input type="text" name="amount" id="amount" class="form-control" value="" required="required" placeholder="Amount..">
							</div>
							<div class="col-sm-1  form-group">
								<label for="quality">Quality</label>
								<div class="checkbox">
									<label>
										<input type="checkbox" value="1" name="quality" id="quality">
										OK
									</label>
								</div>
							</div>
							<div class="col-sm-6 form-group">
								<label for="description" class="control-label">Description:</label>
								<input type="text" name="description" id="description" class="form-control" placeholder="Description..">
							</div>
						</div>
						<div class="row">
								<div class="col-sm-2">
									<button type="submit" class="btn btn-default" id="inspection_button">Add to Inspection table</button>
								</div>
						</div>
					</div>
					
					<div id="inspection_table">
						@include('Quality_Control_View.inspection_table')
					</div>

				</div>
		
			</div>
		</div>
	</form>
</div>

<!-- Modal Validation -->
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

<div class="visible-print" id="print_div"></div>

<script type="text/javascript">
	// Validation Form
	$('#form-register').validate({
		rules:{
			user_id:{
				required:true,
				min:1,
			},
			amount:{
				required:true,
				min:1,
				number:true,
			},
			description:{
				required:true,
				minlength:3,
			}
		},
		messages:{
			user_id:{
				min:"You have to chose a staff!!",
			}
		},
		submitHandler: function(form){
			$.ajax({
					url: '{{Asset("quality-control/inspection-table")}}',
					type: 'post',
					data: $(form).serialize(),
					success: function (data) {
						$('#inspection_table').html(data);
						$('#user_id').val(-1);
						$('#amount').val("");
						$('#quality').removeAttr('checked');
						$('#description').val("");
					}
				});
		}
	});

	$('#form-report').validate({
		rules:{
			date:{
				required:true,
			}
		}
	});

	// Inspection ajax
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
		date        = $('#date').val();
		description = $('#description').val();
		$.ajax({
				url: '{{Asset('data/print-calibrations')}}',
				type: 'post',
				data: {date: date, description: description},
				success: function (data) {
					$('#print_div').html(data);
					window.print();
				}
			});
	});

	// Print Daily Report
	$('#report_print_button').click(function(){
		date        = $('#date').val();
		description = $('#description').val();
		product_id  = $('#product_id').val();
		$.ajax({
				url: '{{Asset('data/print-quality-report')}}',
				type: 'post',
				data: {date: date, description: description, product_id: product_id},
				success: function (data) {
					$('#print_div').html(data);
					window.print();
				}
			});
	});
	

	

</script>

@endsection