@extends("theme")

@section('title')
Modify Project
@endsection

@section('content')
<style>
	td {
		vertical-align: middle!important;
	}
</style>

<div class="container">
	<div class="page-header">
		<h1>Modify Project</h1>
	</div>
	@include('notification')
</div>


<div class="container" id='content'>
	<div class="row">
		{{Former::open()->action(asset('orders/project-modify/'.$project->id))->id('modify-project-form')}}
		<div class="col-sm-6">
			<?php 
			Former::populate($project);
			?>
			<div class="col-sm-12">
				{{Former::text('name')->class('form-control')->placeholder('Name of project..')}}
			</div>
			<div class="col-sm-12">
				{{Former::textarea('note')->class('form-control')->placeholder('Note..')}}
			</div>
			<div class="col-sm-6">
				<?php 
				$status = array('on-process', 'completed', 'canceled');
				?>
				{{Former::select('status')->options($status)->class('form-control')->placeholder('-- Status of project --')}}
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
			<button type="button" id="modify-project-button" class="btn btn-primary btn-block">Update Project</button>
		</div>
	</div>

	<div class="row">
		<ul id="validation_errors"></ul>
	</div>
</div>

<script>


	// New project button submit form
	$('#modify-project-button').click(function(){
		$('#modify-project-form').submit();
	});



</script>

@endsection