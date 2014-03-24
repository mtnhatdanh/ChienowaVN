@extends('theme')

@section('title')
Modify Item
@endsection
@section('content')

<div class="container">
	<div class="page-header">
		<h1>Modify {{ItemAtt::where('item_id', '=', $item->id)->where('attribute_id', '=', 1)->get()->first()->value}} Item</h1>
	</div>
</div>

<div id="content">
	<form action="{{Asset('item/modify-item/'.$item->id)}}" method="post" id="form-register">
		<div class="container">
			<div class="form-group">
				<label for="category" class="col-sm-1 control-label">Category</label>
				<div class="col-sm-3">
					<span class="badge">{{ucfirst($item->category->name)}}</span>
				</div>
			</div>
		</div>
		<br>
		
		<div class="container">
			@foreach ($itematts as $itematt)
			<div class="@if ($itematt->attribute_id==1) col-sm-4 @else col-sm-2 @endif" style="margin-bottom: 5px">
				<label for="{{$itematt->attribute_id}}">{{$itematt->attribute->name}}</label>
				<input type="text" class="form-control @if ($itematt->attribute_id!=1 && $itematt->attribute_id!=8) att_class @endif" 
				id="{{$itematt->attribute_id}}" name="Att{{$itematt->attribute_id}}" placeholder="{{$itematt->attribute->name}}"
				value="{{$itematt->value}}" 
				@if ($itematt->attribute_id==1) readonly @endif
				>
			</div>
			@endforeach
		</div>

		<br/>
		<div class="container text-center">
		<button class="btn btn-primary" type="submit">Update Item</button>
		<button class="btn btn-default" type="button" onclick="window.history.back()">Back</button>
	</div>
	</form>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('.att_class').change(function(){
			var name_string = "{{$item->category->code}}";
			$('.att_class').each(function(){
				if($(this).val()!="") name_string = name_string + '-' + $(this).val();
			});
			$('#1').val(name_string);
		});
	});

	$('#form-register').validate();
	$('.att_class').rules("add", {
		required: true,
	});

</script>

@endsection