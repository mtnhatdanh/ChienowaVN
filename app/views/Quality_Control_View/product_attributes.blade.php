@extends("theme")

@section('title')
Manage Products Attributes
@endsection

@section('content')

<div class="container">
	<div class="page-header">
		<h1>Product Attributes</h1>
	</div>
	@include('notification')
</div>

<div id="content" class="container">
	<div class="row">
		<div class="form-group col-sm-2">
			<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#myModal">Create Product Attributes</button>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-responsive table-striped table-condensed">
				<tr>
					<th class="text-center">No</th>
					<th>Name</th>
					<th>Type</th>
					<th class="text-center">Order No</th>
					<th class="text-center">Action</th>
				</tr>
				<?php $no = 0;?>
				@foreach (ProductAtt::orderBy('order_no', 'asc')->get() as $product_att)
				<tr>
					<td class="text-center">{{++$no}} - {{$product_att->id}}</td>
					<td>{{$product_att->name}}</td>
					<td>{{$product_att->type}}</td>
					<td class="text-center">{{$product_att->order_no}}</td>
					<td class="text-center">
						<button type="button" id="{{$product_att->id}}" class="btn btn-link del_button" data-toggle="modal" data-target="#myDeleteModal">Del</button>
						<button type="button" id="{{$product_att->id}}" class="btn btn-link modify_button" data-toggle="modal" data-target="#myModifyModal">Modify</button>
					</td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>

<!-- Modal Create Equipment -->
<form action="{{Asset('quality-control/product-attributes')}}" method="post" id="form-register">
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">New Product Attribute</h4>
	      </div>
	      <div class="modal-body">
	      		<div class="form-group">
	      			<label for="name" class="control-label">Attribute Name</label>
	      			<input type="text" class="form-control" name="name" id="name" placeholder="Product Name..">
	      		</div>
	      		<div class="form-group">
	      			<label for="type" class="control-label">Type</label>
	      			<input type="text" class="form-control" name="type" id="type" placeholder="Type..">
	      		</div>
	      		<div class="form-group">
	      			<label for="order_no" class="control-label">Order Number</label>
	      			<input type="text" class="form-control" name="order_no" id="order_no" placeholder="Order Number..">
	      		</div>
	      </div>
	      <div class="modal-footer">
	      	<button type="submit" class="btn btn-primary">Create Product Attribute</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>
</form>

<!-- Modal Delete Product Attribute -->
<div class="modal fade" id="myDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Delete product attribute</h4>
      </div>
      <div class="modal-body">
        Are you sure delete this product attribute?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="delete_confirm">Delete Attribute</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Modify Product Attribute -->
<div class="modal fade" id="myModifyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Modify Product Attribute</h4>
      </div>
      <div class="modal-body">
        <div id="modify_div"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="modify_confirm_button">Update Attribute</button>
      </div>
    </div>
  </div>
</div>

<script>
	// Create new equipment validation
	$('#form-register').validate({
		rules:{
			name:{
				required:true,
				minlength:3,
				remote:{
					url:"{{Asset('check/check-product-attribute')}}",
					type:"post"
				}
			},
			order_no:{
				required:true,
				number:true
			}
		},
		messages:{
			name:{
				min:"This product attribute name's already exist!!",
			}
		}
	});

	// Del button
	$('.del_button').click(function(){
		product_att_id = $(this).attr('id');
		$('#delete_confirm').click(function(){
			$.ajax({
				url: '{{Asset('quality-control/delete-product-attribute')}}',
				type: 'post',
				data: {product_att_id: product_att_id},
				success: function (data) {
					location.reload();
				}
			});
		});

	});

	// Modify Button
	$('.modify_button') .click(function(){
		product_att_id = $(this).attr('id');
		$.ajax({
				url: '{{Asset('quality-control/modify-product-attribute')}}',
				type: 'post',
				data: {product_att_id: product_att_id},
				success: function (data) {
					$('#modify_div').html(data);
				}
			});
		$('#modify_confirm_button').click(function(){
			$('#modify_form').submit();
		});
	});

</script>


@endsection