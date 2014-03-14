@extends('theme')

@section('title')
Chienowa Vietnam - Expense Report
@endsection
@section('content')

<div class="container hidden-print">
	<div class="page-header">
		<h1>Expense Report</h1>
	</div>
</div>
<br/>

<?php 
$status = array('OnProcess', 'Approved', 'Canceled');
?>

<div id="content" class="container hidden-print">
	<div class="form-inline">
		<div class="row">
			<div class="form-group col-sm-3">
				<label for="from_day" class="control-label">From day</label>
				<input type="date" class="form-control" id="from_day" name="from_day">
			</div>
			<div class="form-group col-sm-3">
				<label for="to_day" class="control-label">To day</label>
				<input type="date" class="form-control" id="to_day" name="to_day">
			</div>
			<div class="form-group col-sm-3">
				<label for="Status" class="control-label">Status</label>
				<select class="form-control" id="status" name="status">
					<option value="-1">-- All --</option>
					@foreach ($status as $key=>$value)
					<option value="{{$key}}">{{$value}}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group col-sm-3">
				<label for="user_id">Staff</label>
				<select name="user_id" id="user_id" class="form-control">
					<option value="-1">-- All --</option>
					@foreach ($users as $user)
					<option value="{{$user->id}}">{{$user->name}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="col-sm-offset-5 col-sm-2">
				<button class="btn btn-default btn-block" type="button" id="filter_button">Filter</button>
			</div>
		</div>
	</div>
	<br/>
	<div id="result_div"></div>
	
</div>
<div id="print_div"></div>

<script type="text/javascript">
	$(document).ready(function(){

		// Ajax for filter
		$('#filter_button').click(function(){
			from_day = $('#from_day').val();
			to_day   = $('#to_day').val();
			status   = $('#status').val();
			user_id  = $('#user_id').val();
			if(from_day == "" || to_day == "" || from_day > to_day) alert('Invalid input!!');
			else {
				$.ajax({
						url: '{{Asset('report/expense')}}',
						type: 'post',
						data: {from_day: from_day, to_day: to_day, status: status, user_id: user_id},
						success: function (data) {
							$('#result_div').html(data);
						}
					});
			}
		});
	});
</script>

@endsection