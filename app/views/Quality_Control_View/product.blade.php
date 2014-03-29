@extends("theme")

@section('title')
Manage Products
@endsection

@section('content')

<div class="container">
	<div class="page-header">
		<h1>Product list</h1>
	</div>
	@include('notification')
</div>

<div id="content" class="container">
	<div class="row">
		<div class="form-group col-sm-2">
			<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#myModal">Create new Equipment</button>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-responsive table-striped table-condensed">
				<tr>
					<th class="text-center">Product No</th>
					<th>Name</th>
					<th>Description</th>
					<th class="text-center">Action</th>
				</tr>
				@foreach (Product::get() as $product)
				<tr>
					<td class="text-center">{{$product->id}}</td>
					<td>{{$product->name}}</td>
					<td>{{$product->description}}</td>
					<td class="text-center">
						<button type="button" id="{{$product->id}}" class="btn btn-link del_button" data-toggle="modal" data-target="#myDeleteModal">Del</button>
						<a href="{{Asset('quality-control/product-reference/'.$product->id)}}"><button type="button" id="{{$product->id}}" class="btn btn-link ref_button">Reference</button></a>
					</td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>

<!-- Modal Create Equipment -->
<form action="{{Asset('quality-control/product-list')}}" method="post" id="form-register">
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">New Product</h4>
	      </div>
	      <div class="modal-body">
	      	
	      		<div class="form-group">
	      			<label for="name" class="control-label">Product Name</label>
	      			<input type="text" class="form-control" name="name" id="name" placeholder="Product Name..">
	      		</div>
	      		<div class="form-group">
	      			<label for="description" class="control-label">Description</label>
	      			<input type="text" class="form-control" name="description" id="description" placeholder="Description..">
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

<!-- Modal Delete Equipment -->
<div class="modal fade" id="myDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Delete equipment</h4>
      </div>
      <div class="modal-body">
        Are you sure delete this equipment?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="delete_confirm">Delete Equipment</button>
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
					url:"{{Asset('check/check-product')}}",
					type:"post"
				}
			}
		},
		messages:{
			name:{
				min:"This product name's already exist!!",
			}
		}
	});

	// Del button
	$('.del_button').click(function(){
		product_id = $(this).attr('id');
		$('#delete_confirm').click(function(){
			$.ajax({
				url: '{{Asset('quality-control/delete-product')}}',
				type: 'post',
				data: {product_id: product_id},
				success: function (data) {
					location.reload();
				}
			});
		});

	});
</script>


@endsection