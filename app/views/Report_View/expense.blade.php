@extends('theme')

@section('title')
Chienowa Vietnam - Expense Report
@endsection
@section('content')

<div class="container">
	<div class="page-header">
		<h1>Expense Report</h1>
	</div>
</div>
<br/>

<?php 
$status = array('OnProcess', 'Approved', 'Canceled');
?>

<div id="content" class="container">
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
			<div class="form-group col-sm-2">
				<label for="Status" class="control-label">Status</label>
				<select class="form-control" id="status" name="status">
					<option value="All">-- All --</option>
					@foreach ($status as $key=>$value)
					<option value="{{$key}}">{{$value}}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group col-sm-2">
				<button class="btn btn-default" type="button" id="filter_button">Filter</button>
			</div>
		</div>
	</div>
	<br/>
	<div id="result_div"></div>
	
</div>

<script type="text/javascript">
	$(document).ready(function(){

		// Ajax for filter
		$('#filter_button').click(function(){
			category_id = $('#category_id').val();
			from_day    = $('#from_day').val();
			to_day      = $('#to_day').val();
			if(from_day == "" || to_day == "" || from_day > to_day) alert('Wrong Input!!');
			else {
				$.ajax({
						url: '{{Asset('report/inventory-filter')}}',
						type: 'post',
						data: {category_id: category_id, from_day: from_day, to_day: to_day},
						success: function (data) {
							$('#result_div').html(data);
						}
					});
			}
		});
	});
</script>

@endsection