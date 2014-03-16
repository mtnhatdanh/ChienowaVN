@if($notification)
	@if($notification->type=='success')
	<div class="row alert alert-success">{{$notification->value}}</div>
	@endif
	@if($notification->type=='danger')
	<div class="row alert alert-danger">{{$notification->value}}</div>
	@endif
@endif