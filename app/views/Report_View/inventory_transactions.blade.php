@extends('theme')

@section('title')
Chienowa Vietnam - Report Transactions
@endsection
@section('content')

<div class="container">
	<div class="page-header">
		<h1>Transactions</h1>
	</div>
</div>
<br/>

<div id="content" class="container">
	<form action="{{Asset('excel-export/transaction')}}" method="post" id="filter_form">
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
					<label for="transaction_type" class="control-label">Type</label>
					<select class="form-control" id="transaction_type" name="transaction_type">
						<option value="A">--- All ---</option>
						<option value="I">Import</option>
						<option value="E">Export</option>
					</select>
				</div>
				<div class="form-group col-sm-2">
					<button class="btn btn-default btn-block" type="button" id="filter_button" data-loading-text="Loading..">Filter</button>
				</div>
			</div>
		</div>
	<br/>
	</form>
	<div id="result_div"></div>
	
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#filter_button').click(function(){
			from_day = $('#from_day').val();
			to_day   = $('#to_day').val();
			type     = $('#transaction_type').val();
			if(from_day == "" || to_day == "" || from_day > to_day) alert('Wrong Input!!');
			else {
				var btn=$(this);
				btn.button('loading');
				$.ajax({
						url: '{{Asset('report/transactions-filter')}}',
						type: 'post',
						data: {from_day: from_day, to_day: to_day, type: type},
						success: function (data) {
							$('#result_div').html(data);
							btn.button('reset');
						}
					});
			}
		});
	});
</script>
@endsection