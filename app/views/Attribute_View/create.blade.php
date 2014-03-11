@extends('theme')

@section('title')
Chienowa Vietnam - Create New Attribute
@endsection
@section('content')

<div class="container">
	<div class="page-header">
		<h1>Create new Attribute</h1>
	</div>
</div>

<div  id="content">
	<form action="{{Asset('attribute/create-attribute')}}" method="post" class="form-horizontal" id="form-register">
		<div class="container">
			<div class="form-group">
				<label for="name" class="col-sm-2 control-label">Name</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="name" name="name" placeholder="Attribute name..">
				</div>
			</div>
			<div class="form-group">
				<label for="type" class="col-sm-2 control-label">Type</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="type" name="type" placeholder="Type..">
				</div>
			</div>
			<div class="form-group">
				<label for="order_no" class="col-sm-2 control-label">Order Number</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="order_no" name="order_no" placeholder="Order Number..">
				</div>
			</div>

			<div class="col-md-2 col-md-offset-2">
				<button type="submit" class="btn btn-primary hidden-xs">Create new Attribute</button>
			</div>
			<div class="col-md-1">
				<a href="{{Asset('attribute')}}"><button type="button" class="btn btn-default">Back</button></a>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
	$('#form-register').validate({
		rules:{
			name:{
				required:true,
				remote:{
					url:"{{Asset('check/check-attribute')}}",
					type:"post"
				}
			},
			type:{
				required:true,
			},
			order_no: {
				required:true,
			}
		},
		messages:{
			name:{
				remote:"This attribute name's already exists.",
			}
		}
	})
</script>

@endsection