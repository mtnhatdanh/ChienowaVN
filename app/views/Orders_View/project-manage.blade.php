@extends("theme")

@section('title')
Project Manage
@endsection

@section('content')


<div class="container">
	<div class="page-header">
		<h1>Project Manage</h1>
	</div>
	@include('notification')
</div>

<div class="container" id="content">
	<form class="form-inline" role="form">
		<div class="row">
			<div class="col-sm-2">
				{{Former::select('status')->options(array('0'=>'on-process', '1'=>'completed', '2'=>'canceled'))->class('form-control')}}
			</div>
			<div class="col-sm-2">
				<button type="button" class="btn btn-default btn-block" id="filter-button">Filter</button>
			</div>
		</div>
	</form>
	<br/>
	<div id="result-div"></div>
</div>

<script>

	$('#filter-button').click(function(){
		status    = $('#status').val();
		from_date = $('#from_date').val();
		to_date   = $('#to_date').val();
		if(from_date > to_date) alert('Wrong Input!!');
		else {
			$.ajax({
				url: '{{asset("orders/project-manage")}}',
				type: 'POST',
				data: {status: status},
			})
			.done(function(data) {
				$('#result-div').html(data);
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
	

</script>

@endsection