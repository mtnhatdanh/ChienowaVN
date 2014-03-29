@extends("theme")

@section('title')
Product Reference
@endsection

@section('content')
<div id="content">
	<form action="{{Asset('quality-control/product-reference/'.$product->id)}}" method="post" id="form-register">
		<div class="container">
			<div class="page-header">
				<h1>{{ucfirst($product->name)}} References</h1>
			</div>
			<br/>
			@foreach (ProductAtt::orderBy('order_no', 'asc')->get() as $attribute)
			<div class="col-md-3">
				<div class="checkbox">
				  <label>
				    <input type="checkbox" class="attribute" ="attribute" name="attribute[]" value="{{$attribute->id}}"
				    @foreach ($re_show as $reference)
				    	@if ($reference->product_att_id == $attribute->id) checked @endif
				    @endforeach
				    >
				    {{$attribute->name}}
				  </label>
				</div>
			</div>
			@endforeach
		</div>
		<br/>
		<div class="container">
			<div class="row">
				<div class="col-sm-2">
					<button type="submit" class="btn btn-block btn-primary hidden-xs">Save</button>
				</div>
				<div class="col-sm-2">
					<a href="{{Asset('quality-control/product-list')}}"><button class="btn btn-block btn-default" type="button">Back</button></a>
				</div>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
	$('#form-register').validate();
	$('.attribute').rules("add", {
		required: true,
	});
</script>
@endsection