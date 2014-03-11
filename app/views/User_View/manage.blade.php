@extends("theme")

@section('title')
Chienowa Vietnam - Manage Users
@endsection

@section('content')
<div class="container" id="content">
	<h1>Manage User</h1>

	<br/>
	<p><span class="label label-primary">Director</span> <strong>Mr {{$director[0]->name}}</strong></p>
	
	<table class="table table-responsive table-striped table-bordered">
		<tr>
			<th>No</th>
			<th>Name</th>
			<th>Position</th>
			<th class="hidden-xs">Mobile</th>
			<th class="hidden-xs">Email</th>
			<th class="hidden-xs">Address</th>
			<th class="hidden-xs">Delete</th>
			<th class="hidden-xs">Username</th>
		</tr>
		<?php
		$no = 1;
		?>
		@foreach ($users as $user)
		<tr>
			<td>{{$no}}</td>
			<td><a href="{{Asset('user/modify-user/'.$user->id)}}">{{$user->name}}</a></td>
			<td>{{$user->position->position_name}}</td>
			<td class="hidden-xs">{{$user->mobile}}</td>
			<td class="hidden-xs">{{$user->email}}</td>
			<td class="hidden-xs">{{$user->address}}</td>
			<td class="del_td hidden-xs"><button type="button" class="btn btn-link" data-toggle="modal" data-target="#myModal{{$user->id}}">Del</button></td>

			<!-- Modal -->
			<div class="modal fade" id="myModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        <h4 class="modal-title" id="myModalLabel">Delete user</h4>
			      </div>
			      <div class="modal-body">
			        Are you sure delete user <b>{{$user->username}}</b>?
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        <a href="{{Asset('user/delete-user/'.$user->id)}}"><button type="button" class="btn btn-primary">Delete User</button>
			      </div>
			    </div>
			  </div>
			</div>

			<!-- <td class="del_td"><a href="{{Asset('user/delete-user/'.$user->id)}}"><button type="button" class="btn btn-danger">Del</button></a></th> -->
			<td class="hidden-xs">{{$user->username}}</td>
		</tr>
		<?php $no++; ?>
		@endforeach
	</table>
	<div>
		<a href="{{Asset('user/create-user')}}"><button type="button" class="btn btn-primary hidden-xs">Create user</button></a>
	</div>
</div>
@endsection