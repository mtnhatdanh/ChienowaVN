@extends('theme')

@section('title')
Supplier Report
@endsection
@section('content')

<div class="container">
	<div class="page-header">
		<h1>Supplier Report</h1>
	</div>
</div>
<br/>

<div id="content" class="container">
	<div class="form-inline">
		<div class="row">
			<div class="col-sm-4">
				{{Former::select('supplier')->id('supplier_id')->fromQuery(Supplier::all(), 'name', 'id')->placeholder('-- Select Supplier --')->class('form-control')->inline()}}
			</div>
			<div class="col-sm-4">
				{{Former::select('statement_type')->id('statement_type')->options(array(0=>'Quotations', 1=>'Orders'))->class('form-control')->placeholder('-- Select statement type --')}}
			</div>
		</div>
		<div class="row" style="margin-top: 1em">
			<div class="col-sm-4">
				<label for="from_day" class="control-label">From day</label>
				<input type="date" class="form-control" id="from_day" name="from_day">
			</div>
			<div class="col-sm-4">
				<label for="to_day" class="control-label">To day</label>
				<input type="date" class="form-control" id="to_day" name="to_day">
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
	$(document).ready(function(){

		// Ajax for filter
		$('#filter_button').click(function(){
			supplier_id    = $('#supplier_id').val();
			statement_type = $('#statement_type').val();
			from_day       = $('#from_day').val();
			to_day         = $('#to_day').val();
			if(from_day > to_day || supplier_id === null || statement_type === null) alert('Wrong Input!!');
			else {
				var btn=$(this);
				btn.button('loading');
				$.ajax({
					url: '{{asset("report/supplier-report")}}',
					type: 'POST',
					data: {supplier_id: supplier_id, statement_type:statement_type, from_day: from_day, to_day: to_day},
				})
				.done(function(data) {
					$('#result_div').html(data);
					btn.button('reset');
					console.log("success");
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});
				
			}
		});
	});
</script>

@endsection