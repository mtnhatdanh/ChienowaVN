@extends("theme")

@section('title')
Chienowa Vietnam - Manage Attributes
@endsection

@section('content')
<div class="container" id="content">
	<h1>Manage Attributes</h1>

	<br/>
	
	<table class="table table-responsive table-striped table-bordered table-condensed">
		<tr>
			<th>No</th>
			<th>Name</th>
			<th>Type</th>
			<th>Order Number</th>
		</tr>
		<?php
		$no = 1;
		?>
		@foreach ($attributes as $attribute)
		<tr>
			<td class="text-center">{{$no}}</td>
			<td>{{$attribute->name}}</td>
			<td>{{$attribute->type}}</td>
			<td>{{$attribute->order_no}}</td>
		</tr>
		<?php $no++; ?>
		@endforeach
	</table>
	<div>
		<a href="{{Asset('attribute/create-attribute')}}"><button type="button" class="btn btn-primary hidden-xs">Create new attribute</button></a>
	</div>
</div>
@endsection