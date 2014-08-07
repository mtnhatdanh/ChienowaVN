@extends("theme")

@section('title')
Quotation Modify
@endsection

@section('content')
<style>
	td {
		vertical-align: middle!important;
	}
</style>

<div class="container">
	<div class="page-header">
		<h1>Modify Quotation<br/>
		<small>Project: {{Project::find($quotation->project_id)->name;}}</small>
		</h1>
	</div>
	@include('notification')
</div>


<div class="container" id='content'>
	<div class="row">
		{{Former::open()->action(asset('orders/quotation-modify/'.$quotation->id))->id('modify-quotation-form')}}
		{{Former::populate(Quotation::find($quotation->id))}}
		<div class="col-sm-6">
			<div class="col-sm-6">
				{{Former::select('user_id')->options(array($quotation->user->id=>$quotation->user->name))->label('User')->class('form-control')->readonly()}}
			</div>
			<div class="col-sm-6">
				{{Former::date('date')->class('form-control')->readonly()}}
			</div>
			<div class="col-sm-12">
				<label for="supplier_name" class="control-label">Supplier name</label>
				<div class="input-group">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button" data-toggle="modal" data-target="#lookup-supplier" id="lookup_btn"><span class="glyphicon glyphicon-search"></span></button>
					</span>
					<input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder="Supplier name.." value="{{$quotation->supplier->name}}">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button" data-toggle="modal" data-target="#modal-supplier-info" id="info_btn" ><span class="glyphicon glyphicon-info-sign"></span></button>
						<button class="btn btn-default" type="button" data-toggle="modal" data-target="#modal-new-supplier"><span class="glyphicon glyphicon-plus"></span></button>
					</span>
					{{Former::hidden('supplier_id')->id('supplier_id')->value($quotation->supplier_id)}}
				</div>
			</div>
			<div class="col-sm-6">
				{{Former::date('completed_date')->class('form-control')->id('completed_date')}}
			</div>
			<div class="col-sm-6">
				<?php 
				$status = array('on-proccess', 'completed');
				?>
				<label for="status" class="control-label">Status</label>
				<select name="status" id="status" class="form-control">
					<option value="0" @if ($quotation->status == 0) selected @endif>
						{{$status[0]}}
					</option>
					<option value="1" @if ($quotation->status == 1) selected @endif>
						{{$status[1]}}
					</option>
				</select>
			</div>
			<div class="col-sm-12">
				{{Former::textarea('note')->class('form-control')->placeholder('Note..')}}
			</div>
		</div>
		{{Former::close()}}
		<!-- Panel -->
		<div class="col-sm-6">
			@include('Orders_View.quotation-products-panel')
		</div>
	</div>
	<br/>
	<div class="row">
		<div class="col-sm-2 col-sm-offset-5">
			<button type="button" id="update-quotation-button" class="btn btn-primary btn-block">Update Quotation</button>
		</div>
	</div>

	<div class="row">
		<ul id="validation_errors"></ul>
	</div>
</div>

{{Former::open()->id('lookup-supplier-form')}}
<div class="modal fade bs-example-modal-lg" id="lookup-supplier">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Supplier lookup</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-3">
						{{Former::text('Search_name')->class('form-control')}}
					</div>
					<div class="col-sm-3">
						{{Former::text('Search_main_Products')->class('form-control')}}
					</div>
					<div class="col-sm-3">
						{{Former::text('Search_repersentative')->class('form-control')}}
					</div>
					<div class="col-sm-3">
						<strong>Rating</strong><br/>
						<span class="rating">
						    <input type="radio" class="rating-input"
						        id="rating-input-1-5" name="rating" value="5">
						    <label for="rating-input-1-5" class="rating-star"></label>
						    <input type="radio" class="rating-input"
						        id="rating-input-1-4" name="rating"  value="4">
						    <label for="rating-input-1-4" class="rating-star"></label>
						    <input type="radio" class="rating-input"
						        id="rating-input-1-3" name="rating" value="3">
						    <label for="rating-input-1-3" class="rating-star"></label>
						    <input type="radio" class="rating-input"
						        id="rating-input-1-2" name="rating"  value="2">
						    <label for="rating-input-1-2" class="rating-star"></label>
						    <input type="radio" class="rating-input"
						        id="rating-input-1-1" name="rating" value="1">
						    <label for="rating-input-1-1" class="rating-star"></label>
						</span>
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-sm-3">
						<button type="submit" class="btn btn-default" id="lookup-button">Lookup Supplier</button>
					</div>
				</div>
				<div id="result-div"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="pick-supplier-button">Pick Supplier</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{{Former::close()}}

<!-- Infomation Modal -->
<div class="modal fade" id="modal-supplier-info">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Supplier Infomation</h4>
			</div>
			<div class="modal-body">
				<div id="supplier-info-div"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal for new Supplier -->
{{Former::open()->rules(array('name'=>'required','email'=>'email'))->action(asset('orders/supplier-create'))->id('new-supplier-form')}}
<div class="modal fade bs-example-modal-lg" id="modal-new-supplier">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">New Supplier</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-4">
						{{Former::text('name')->class('form-control')->placeholder('Supplier name')}}
					</div>
					<div class="col-sm-4">
						{{Former::text('address')->class('form-control')->placeholder('Supplier address')}}
					</div>
					<div class="col-sm-4">
						{{Former::text('email')->class('form-control')->placeholder('Email')}}
					</div>
					<div class="col-sm-4">
						{{Former::text('main_product')->class('form-control')->placeholder('Main Product')}}
					</div>
					<div class="col-sm-4">
						{{Former::text('phone')->class('form-control')->placeholder('Phone')}}
					</div>
					<div class="col-sm-4">
						{{Former::text('representative')->class('form-control')->placeholder('Repersentative')}}
					</div>
					<div class="col-sm-4">
						{{Former::text('mobile')->class('form-control')->placeholder('Mobile')}}
					</div>
					<div class="col-sm-4">
						{{Former::text('website')->class('form-control')->placeholder('Website')}}
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-sm-4">
						<strong>Rating</strong><br/>
						<span class="rating">
						    <input type="radio" class="rating-input"
						        id="rating-input-6-5" name="rating" value="5">
						    <label for="rating-input-6-5" class="rating-star"></label>
						    <input type="radio" class="rating-input"
						        id="rating-input-6-4" name="rating"  value="4">
						    <label for="rating-input-6-4" class="rating-star"></label>
						    <input type="radio" class="rating-input"
						        id="rating-input-6-3" name="rating" value="3">
						    <label for="rating-input-6-3" class="rating-star"></label>
						    <input type="radio" class="rating-input"
						        id="rating-input-6-2" name="rating"  value="2">
						    <label for="rating-input-6-2" class="rating-star"></label>
						    <input type="radio" class="rating-input"
						        id="rating-input-6-1" name="rating" value="1">
						    <label for="rating-input-6-1" class="rating-star"></label>
						</span>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						{{Former::textarea('note')->class('form-control')->placeholder('Note')}}
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">New supplier</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{{Former::close()}}

<script>

	// New quotation button
	$('#update-quotation-button').click(function(){
		completed_date = $('#completed_date').val();
		status = $('#status').val();
		if (completed_date == '' && status == 1) {
			alert('Not input completed date yet!!');
		} else {
			$('#modify-quotation-form').submit();
		}
	});

	// Modify Quotation validate
	$('#modify-quotation-form').validate({
		errorLabelContainer: "#validation_errors",
		wrapper: "li",
		rules: {
			date: {
				required: true,
				date: true
			},
			supplier_name: {
				required: true,
				remote: {
					url:"{{Asset('check/check-supplier-exist')}}",
					type:"post"
				}
			},
			supplier_id: {
				required: true
			}
		}
	});

	// Lookup Suplier form validate
	$('#lookup-supplier-form').validate({
		submitHandler: function(form) {
			$.ajax({
				url: '{{asset('orders/supplier-lookup')}}',
				type: 'post',
				data: $('#lookup-supplier-form').serialize(),
				success: function (data) {
					$('#result-div').html(data);
				}
			});	
		}
	});

	// Infomation Button
	$('#info_btn').click(function(){
		supplier_id = $('#supplier_id').val();
		$.ajax({
			url: '{{asset('orders/supplier-info')}}',
			type: 'post',
			data: {supplier_id: supplier_id},
		})
		.done(function(data) {
			$('#supplier-info-div').html(data);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	});
	

	// Pick lookup Supplier Button
	$('#pick-supplier-button').click(function(){
		supplier_id          = $('#supplier-select').val();
		supplier_name_string = $('#supplier-select').find(":selected").text();
		supplier_name_array  = supplier_name_string.split('---');
		supplier_name        = supplier_name_array[0];

		if (supplier_id == null) alert('You did not pick a supplier!!');
		else {
			$('#supplier_id').val(supplier_id);
			$('#supplier_name').val(supplier_name);
			$('#lookup-supplier').modal('hide');
		}
	});

	// Autocomplete for Supplier name
	$('#supplier_name').autocomplete({
	    serviceUrl: '{{asset('orders/supplier-autocomplete')}}',
	    onSelect: function (suggestion) {
	    	$('#supplier_id').val(suggestion.data);
	        // alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
	    }
	});



</script>

@endsection