@if($notification)
	<div class="row alert alert-{{$notification->type}} alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<strong>{{ucfirst($notification->type)}}!!</strong> {{$notification->value}}
	</div>
@endif