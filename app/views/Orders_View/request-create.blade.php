@extends("theme")

@section('title')
Request Create
@endsection

@section('content')

<div class="container">
	<div class="page-header">
		<h1>Create new Request</h1>
	</div>
	@include('notification')
</div>

{{Former::open()->action(asset('orders/request-create'))->id('new-request-form')}}
<div class="container" id='content'>
	<div class="row">
		<div class="col-sm-3">
			{{Former::select('user_id')->options(array(Session::get('user')->id=>Session::get('user')->name))->label('User')->class('form-control')->readonly()}}
		</div>
		<div class="col-sm-3">
			{{Former::date('date')->class('form-control')->value(date('Y-m-d'))->readonly()}}
		</div>
		<div class="col-sm-3">
			{{Former::select('incharge_staff_id')->fromQuery(User::where('id', '!=', 16)->get(), 'name', 'id')->class('form-control')->label('Incharge Staff')->placeholder('-- Pick an incharge Staff --')}}
		</div>
		<div class="col-sm-3">
			{{Former::date('due_date')->class('form-control')}}
		</div>
		<div class="col-sm-12">
			{{Former::text('request_content')->class('form-control')->placeholder('Request Content')}}
		</div>
		<div class="col-sm-12">
			{{Former::textarea('note')->class('form-control')->placeholder('Note')}}
		</div>
	</div>
	<br/>
	<div class="row">
		<div class="col-sm-2">
			<button type="button" id="new-request-button" class="btn btn-primary btn-block">New Request</button>
		</div>
	</div>
</div>
{{Former::close()}}


<script>

	// New quotation button
	$('#new-request-button').click(function(){
		create_date = $('#date').val();
		due_date = $('#due_date').val();
		if (create_date>due_date) alert('Create date is bigger than Due Day!!');
		else {
			$('#new-request-form').submit();
		}
	});

	// New Quotation validate
	$('#new-request-form').validate({
		rules: {
			due_date: {
				required: true,
				date: true
			},
			incharge_staff_id: {
				required: true
			},
			request_content: {
				required:true
			}
		}
	});
	
</script>

@endsection