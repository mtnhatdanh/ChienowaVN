@extends("theme")

@section('title')
Manage Order Product
@endsection

@section('content')

<div class="container">
	<div class="page-header">
		<h1>Order Product list</h1>
	</div>
	@include('notification')
</div>

<div id="content" class="container">
	<div class="row">
		<div class="form-group col-sm-2">
			<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#myModal">Create new Order Product</button>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-responsive table-striped table-condensed">
				<tr>
					<th class="text-center">No</th>
					<th>Name</th>
					<th>Note</th>
					<th class="text-center">Action</th>
				</tr>
				<?php $no = 0;?>
				@foreach (OrderProduct::all() as $or_product)
				<tr>
					<td class="text-center">{{++$no}}</td>
					<td>{{$or_product->name}}</td>
					<td>{{$or_product->note}}</td>
					<td class="text-center">
						<button type="button" id="{{$or_product->id}}" class="btn btn-link del_button" data-toggle="modal" data-target="#myDeleteModal">Del</button>
					</td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>

<!-- Modal Create Equipment -->
<form action="{{asset('orders/order-product-create')}}" method="post" id="form-register">
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">New Order Product</h4>
	      </div>
	      <div class="modal-body">
	      		<div class="form-group">
	      			<label for="name" class="control-label">Order Product Name</label>
	      			<input type="text" class="form-control" name="name" id="name" placeholder="Product Name..">
	      		</div>
	      		<div class="form-group">
	      			<label for="note" class="control-label">Note</label>
	      			<input type="text" class="form-control" name="note" id="note" placeholder="Note..">
	      		</div>
	      </div>
	      <div class="modal-footer">
	      	<button type="submit" class="btn btn-primary">Create new Product</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>
</form>

<!-- Modal Delete Order Product -->
<form action="{{asset('orders/order-product-delete')}}" method="post">
<div class="modal fade" id="myDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Delete equipment</h4>
      </div>
      <div class="modal-body">
        Are you sure delete this equipment?
        {{Former::hidden('orderProduct_id')->id('orderProduct_id')}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="delete_confirm">Delete Order Product</button>
      </div>
    </div>
  </div>
</div>
</form>

<script>
	// Create new equipment validation
	$('#form-register').validate({
		rules:{
			name:{
				required:true,
				minlength:3,
				remote:{
					url:"{{Asset('check/check-order-product')}}",
					type:"post"
				}
			}
		},
		messages:{
			name:{
				remote:"This product name's already exist!!",
			}
		}
	});

	// Del button
	$('.del_button').click(function(){
		orderProduct_id = $(this).attr('id');
		$('#orderProduct_id').val(orderProduct_id);
	});
</script>


@endsection