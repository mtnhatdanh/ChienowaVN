@extends("theme")

@section('title')
Chienowa Vietnam - Reference
@endsection

@section('content')
<form action="{{Asset('category/reference/'.$category_id)}}" method="post" id="form-register">
	<div class="container" id="content">
		<div class="page-header">
			<h1>{{ucfirst(Category::find($category_id)->name)}} References</h1>
		</div>
		<br/>
		@foreach (Attribute::orderBy('order_no', 'asc')->get() as $attribute)
		<div class="col-md-3">
			<div class="checkbox">
			  <label>
			    <input type="checkbox" class="attribute" ="attribute" name="attribute[]" value="{{$attribute->id}}"
			    @foreach ($re_show as $reference)
			    	@if ($reference->attribute_id == $attribute->id) checked @endif
			    @endforeach
			    >
			    {{$attribute->name}}
			  </label>
			</div>
		</div>
		@endforeach
	</div>
	<div class="container">
		<button type="submit" class="btn btn-primary">Save</button>
		<a href="{{Asset('category')}}"><button class="btn btn-default" type="button">Back</button></a>
	</div>
</form>

<script type="text/javascript">
	$('#form-register').validate();
	$('.attribute').rules("add", {
		required: true,
	});
</script>
@endsection