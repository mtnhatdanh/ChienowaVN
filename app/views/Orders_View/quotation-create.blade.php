@extends("theme")

@section('title')
Quotation Create
@endsection

@section('content')

<style>
	.autocomplete-suggestions { border: 1px solid #999; background: #FFF; cursor: default; overflow: auto; -webkit-box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); -moz-box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); }
	.autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
	.autocomplete-selected { background: #F0F0F0; }
	.autocomplete-suggestions strong { font-weight: normal; color: #3399FF; }
</style>


<div class="container">
	<div class="page-header">
		<h1>Create new Quotation</h1>
	</div>
	@include('notification')
</div>

{{Former::open()->action(asset('orders/quotation-new'))->id('new-quotation-form')}}
<div class="container">
	<div class="row">
		<div class="col-sm-3">
			{{Former::select('user_id')->options(array(Session::get('user')->id=>Session::get('user')->name))->label('User')->class('form-control')}}
		</div>
		<div class="col-sm-3">
			{{Former::date('date')->class('form-control')}}
		</div>
		<div class="form-group col-sm-6">
			<label for="supplier_name" class="control-label">Supplier name</label>
			<div class="input-group">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button" data-toggle="modal" data-target="#lookup-supplier" id="lookup_btn"><span class="glyphicon glyphicon-search"></span></button>
				</span>
				<input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder="Supplier name..">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button" data-toggle="modal" data-target="#modal-supplier-info" id="info_btn" ><span class="glyphicon glyphicon-info-sign"></span></button>
					<button class="btn btn-default" type="button" data-toggle="modal" data-target="#modal-new-supplier"><span class="glyphicon glyphicon-plus"></span></button>
				</span>
				{{Former::hidden('supplier_id')->id('supplier_id')}}
			</div>
		</div>
		<div class="col-sm-3">
			{{Former::text('Product')->class('form-control')}}
		</div>
		<div class="col-sm-3">
			{{Former::date('Due_date')->class('form-control')}}
		</div>
		<div class="col-sm-3">
			<?php
			$status = array('on-process', 'completed');
			?>
			{{Former::select('status')->options($status)->class('form-control')}}
		</div>
		<div class="col-sm-12">
			{{Former::textarea('note')->class('form-control')->placeholder('Note')}}
		</div>
	</div>
	<br/>
	<div class="row">
		<div class="col-sm-3">
			<button type="button" id="new-quotation-button" class="btn btn-primary btn-block">New Quotaion</button>
		</div>
	</div>
	<br/>
	<div class="row">
		<ul id="validation_errors"></ul>
	</div>
</div>
{{Former::close()}}

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
	$('#new-quotation-button').click(function(){
		create_date = $('#date').val();
		due_date = $('#Due_date').val();
		if (create_date>due_date) alert('Create date is bigger than Due Day!!');
		else {
			$('#new-quotation-form').submit();
		}
	});

	// New Quotation validate
	$('#new-quotation-form').validate({
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
			},
			Due_date: {
				required: true
			},
			Product: {
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