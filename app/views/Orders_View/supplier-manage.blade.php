@extends("theme")

@section('title')
Supplier Manage
@endsection

@section('content')

<style>
	table#supplier-table td {
		vertical-align: middle;
	}
</style>

<div class="container">
	<h1>Manage Supplier</h1>
	@include('notification')
	<br/>
	<div class="row">
		<div class="col-sm-3">
			<button type="button" class="btn btn-default" data-toggle="modal" href='#modal-new-supplier'>Create new Supplier</button>
		</div>
	</div>
	<br/>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-responsive table-striped table-condensed" id="supplier-table">
				<tr>
					<th>No</th>
					<th>Name</th>
					<th>Address</th>
					<th>Email</th>
					<th>Phone</th>
					<th>Website</th>
					<th class="text-center">Representative</th>
					<th class="text-center">Action</th>
				</tr>
				<?php $no = 0;?>
				@foreach (Supplier::get() as $supplier)
				<tr>
					<td>{{++$no}}</td>
					<td>{{$supplier->name}}</td>
					<td>{{$supplier->address}}</td>
					<td>{{$supplier->email}}</td>
					<td>{{$supplier->phone}}</td>
					<td>{{$supplier->website}}</td>
					<td class="text-center">{{$supplier->representative}} <button id="{{$supplier->id}}" class="btn btn-link info-button"><span class='glyphicon glyphicon-info-sign'></span></button></td>
					<td class="text-center">
						<button id="{{$supplier->id}}" class="btn btn-link modify-button">Modify</button>
						<button id="{{$supplier->id}}" class="btn btn-link delete-button">Delete</button>
					</td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>

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

<!-- Representative infomation modal -->
<div class="modal fade" id="modal-info">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Representative Infomation</h4>
			</div>
			<div class="modal-body">
				<div id="representative-info"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Delete Supplier Confirmation Modal -->
{{Former::open()->action(asset('orders/supplier-delete'))}}
<div class="modal fade" id="modal-delete">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Delete Supplier</h4>
			</div>
			<div class="modal-body">
				{{Former::hidden('supplier_id')->id('supplier-delete-id')}}
				Are your sure to delete this Supplier???
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Delete Supplier</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{{Former::close()}}

<!-- Modify Supplier Modal -->
{{Former::open()->rules(array('name'=>'required','email'=>'email'))->action(asset('orders/supplier-modify-confirm'))->id('modify-supplier-form')}}
<div class="modal fade bs-example-modal-lg" id="modal-modify">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Modify Supplier</h4>
			</div>
			<div class="modal-body">
				<div id="modify-supplier-div"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Update</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{{Former::close()}}

<script type="text/javascript">
	// Validate form
	$('#new-supplier-form').validate({
		rules:{
			name:{
				required:true,
				remote:{
					url:"{{Asset('check/check-supplier')}}",
					type:"post"
				}
			}
		}
	});

	// Info button
	$('.info-button').click(function(){
		supplier_id = $(this).attr('id');
		$.ajax({
				url: '{{asset('orders/supplier-info')}}',
				type: 'post',
				data: {supplier_id: supplier_id},
				success: function (data) {
					$('#representative-info').html(data);
					$('#modal-info').modal('show');
				}
			});

	});

	// Delete button
	$('.delete-button').click(function(){
		supplier_id = $(this).attr('id');
		$('#supplier-delete-id').val(supplier_id);
		$('#modal-delete').modal('show');
	});

	// Modify button
	$('.modify-button').click(function(){
		supplier_id = $(this).attr('id');
		$.ajax({
				url: '{{asset('orders/supplier-modify')}}',
				type: 'post',
				data: {supplier_id: supplier_id},
				success: function (data) {
					$('#modify-supplier-div').html(data);
					$('#modal-modify').modal('show');
				}
			});
	});

</script>
@endsection