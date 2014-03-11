@extends('theme')

@section('title')
Chienowa Vietnam - Modify  User
@endsection
@section('content')

<div class="container">
	<div class="page-header">
		<h1>Modify  user {{$user->username}}</h1>
	</div>
</div>

<div  id="content">
	<form action="{{Asset('user/modify-user/'.$user->id)}}" method="post" class="form-horizontal" id="form-register">
		<div class="container">
			<div class="form-group">
				<label for="name" class="col-sm-2 control-label">Name</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="name" name="name" placeholder="Enter your name.." value="{{$user->name}}">
				</div>
			</div>
			<div class="form-group">
				<label for="position" class="col-sm-2 control-label">Position</label>
				<div class="col-sm-4">
					<select name="position_id" id="position_id" class="form-control">
						@foreach (Position::get() as $position)
						<option <?php if($position->id==$user->position_id) echo "selected"; ?> value="{{$position->id}}">{{$position->position_name}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="mobile" class="col-sm-2 control-label">Mobile</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter your mobile.." value="{{$user->mobile}}">
				</div>
			</div>
			<div class="form-group">
				<label for="email" class="col-sm-2 control-label">Email</label>
				<div class="col-sm-4">
					<input type="email" class="form-control" id="email" name="email" placeholder="Enter your email.." value="{{$user->email}}">
				</div>
			</div>
			<div class="form-group">
				<label for="address" class="col-sm-2 control-label">Address</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="address" name="address" placeholder="Enter your address.." value="{{$user->address}}">
				</div>
			</div>
			<div class="form-group hidden-xs">
				<label for="password" class="col-sm-2 control-label">Password</label>
				<div class="col-sm-4">
					<input type="password" class="form-control" id="password" name="password" placeholder="Leave blank if dont' want to change password">
				</div>
			</div>
			<div class="form-group hidden-xs">
				<label for="password_confirmation" class="col-sm-2 control-label">Re-Password</label>
				<div class="col-sm-4">
					<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re-enter your password..">
				</div>
			</div>
			<div class="col-sm-2 col-sm-offset-2 hidden-xs">
				<button type="submit" class="btn btn-primary">Update user</button>
				
			</div>
			<div class="col-sm-1">
				<a href="{{Asset('user/manage-user')}}"><button type="button" class="btn btn-default">Back</button></a>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
	$('#form-register').validate({
		rules:{
			name:{
				required:true,
				minlength:6,
			},
			password:{
				minlength:6,
			},
			password_confirmation:{
				equalTo:"#password"
			},
			email:{
				required:true,
				email:true,
			}
		},
		messages:{
			username:{
				remote:"This username already exists.",
			}
		}
	})
</script>

@endsection