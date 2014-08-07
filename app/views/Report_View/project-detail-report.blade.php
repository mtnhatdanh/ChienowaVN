@extends('theme')

@section('title')
Project Detail Report
@endsection
@section('content')

<div class="container hidden-print">
	<div class="page-header">
		<h1>Project Report</h1>
	</div>
</div>
<br/>

<?php 
$status = array('OnProcess', 'Completed', 'Canceled');
?>

<div id="content" class="container hidden-print">
	<div class="form-inline">
		<div class="row">
			<div class="form-group col-sm-3">
				<label for="status" class="control-label">Status</label>
				<select name="status" id="inputStatus" class="form-control" required="required">
					<option disabled>-- Pick Project Status --</option>
					@foreach ($status as $key=>$value)
					<option value="{{$key}}">{{$value}}</option>
					@endforeach
				</select>
			</div>
			<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 form-group">
				<label for="project_id">Project Name</label>
				<select name="project_id" id="project_id" class="form-control" required="required">
					<option disabled>-- Pick a project name --</option>
				</select>
			</div>
			<div class="col-sm-2">
				<button class="btn btn-default btn-block" type="button" id="filter_button" data-loading-text="Loading..">Filter</button>
			</div>
		</div>
	</div>
	<br/>
	<div id="result_div"></div>
	
</div>

<script type="text/javascript">
	// Select Status change
	$('#inputStatus').change(function(){
		status = $(this).val();
		$.ajax({
			url: '{{asset("report/project-status-ajax")}}',
			type: 'POST',
			data: {status: status},
		})
		.done(function(data) {
			console.log("success");
			$('#project_id').html(data);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	});

	// Filter button handle
	$('#filter_button').click(function(){
		project_id = $('#project_id').val();
		if (project_id == null) {
			alert('Pick a project name first!!');
		} else {
			var btn=$(this);
			btn.button('loading');
			$.ajax({
				url: '{{asset("report/project-detail-ajax")}}',
				type: 'POST',
				data: {project_id: project_id},
			})
			.done(function(data) {
				console.log("success");
				$("#result_div").html(data);
				btn.button('reset');
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
			
		}
	});
</script>

@endsection