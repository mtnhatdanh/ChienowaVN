@extends('theme')

@section('title')
Chienowa Vietnam - Create User
@endsection
@section('content')

<div class="container">
	<div class="page-header">
		<h1>Create new user</h1>
	</div>
</div>

<div  id="content">
	{{Former::open()->action(asset('user/create-user'))->id('form-register')}}
	<!-- <form action="{{Asset('user/create-user')}}" method="post" class="form-horizontal" id="form-register"> -->
		<div class="container">
			<div class="row form-group">
				<div class="col-sm-3">
					{{Former::text('name')->addClass('form-control')->placeholder('Enter your name..')}}
				</div>
				<div class="col-sm-3">
					{{Former::select('position_id')->class('form-control')->fromQuery(Position::get(), 'position_name', 'id')->label('Position')}}
				</div>
			</div>
			<div class="row form-group">
				<div class="col-sm-3">
					{{Former::text('username')->class('form-control')->placeholder('Enter your username..')}}
				</div>
				<div class="col-sm-3">
					{{Former::password('password')->class('form-control')->placeholder('Enter your password')}}
				</div>
				<div class="col-sm-3">
					{{Former::password('password_confirmation')->class('form-control')->placeholder('Re-enter your password')}}
				</div>
			</div>
			<div class="row form-group">
				<div class="col-sm-3">
					{{Former::text('mobile')->class('form-control')->placeholder('Enter your mobile..')}}
				</div>
				<div class="col-sm-3">
					{{Former::text('email')->class('form-control')->placeholder('Enter your email..')}}
				</div>
				<div class="col-sm-6">
					{{Former::text('address')->class('form-control')->placeholder('Enter your address..')}}
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-2">
					<button type="submit" class="btn btn-primary">Create new user</button>
				</div>
				<div class="col-md-1">
					<a href="{{Asset('user/manage-user')}}"><button type="button" class="btn btn-default">Back</button></a>
				</div>
			</div>
		</div>
	<!-- </form> -->
	{{Former::close()}}
</div>

<script type="text/javascript">
	$('#form-register').validate({
		rules:{
			name:{
				required:true,
				minlength:6,
			},
			username:{
				required:true,
				minlength:3,
				remote:{
					url:"{{Asset('check/check-username')}}",
					type:"post"
				}
			},
			password:{
				required:true,
				minlength:6,
			},
			password_confirmation:{
				equalTo:"#password"
			},
			email:{
				required:true,
				email:true
			}
		},
		messages:{
			username:{
				remote:"This username already exists.",
			}
		}
	});
</script>

@endsection