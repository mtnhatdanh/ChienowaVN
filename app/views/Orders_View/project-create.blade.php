@extends("theme")

@section('title')
Quotation New Project
@endsection

@section('content')
<style>
	td {
		vertical-align: middle!important;
	}
</style>

<div class="container">
	<div class="page-header">
		<h1>Create new Project</h1>
	</div>
	@include('notification')
</div>


<div class="container" id='content'>
	<div class="row">
		{{Former::open()->action(asset('orders/project-create'))->id('new-project-form')}}
		<div class="col-sm-6">
			<div class="col-sm-12">
				{{Former::text('name')->class('form-control')->placeholder('Name of project..')}}
			</div>
			<div class="col-sm-12">
				{{Former::textarea('note')->class('form-control')->placeholder('Note..')}}
			</div>
		</div>
		{{Former::close()}}
		<!-- Panel -->
		<div class="col-sm-6">
			@include('Orders_View.project-products-panel')
		</div>
	</div>
	<br/>
	<div class="row">
		<div class="col-sm-2 col-sm-offset-5">
			<button type="button" id="new-project-button" class="btn btn-primary btn-block">New Project</button>
		</div>
	</div>

	<div class="row">
		<ul id="validation_errors"></ul>
	</div>
</div>

<script>


	// New project button submit form
	$('#new-project-button').click(function(){
		$('#new-project-form').submit();
	});



</script>

@endsection