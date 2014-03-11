@extends("theme")

@section('title')
Chienowa Vietnam - Category
@endsection

@section('content')
<div class="container" id="content">
	<h1>Category</h1>

	<br/>
	<?php
	$no = 1;
	?>
	<table class="table table-responsive table-striped table-bordered">
		<tr>
			<th>No</th>
			<th>Name</th>
			<th>Code</th>
			<th>Reference</th>
		</tr>
		@foreach ($categories as $category)
		<tr>
			<td class="text-center">{{$no}}</td>
			<td class="text-center"><a href="{{Asset('category/manage-item/'.$category->name)}}">{{ucfirst($category->name)}}</a></td>
			<td class="text-center">{{$category->code}}</td>
			<td class="text-center"><a href="{{Asset('category/reference/'.$category->id)}}">Ref</a></td>
		</tr>
		<?php
		$no++;
		?>
		@endforeach
	</table>
</div>
@endsection