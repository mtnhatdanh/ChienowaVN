@extends('theme')

@section('title')
Create New Items
@endsection
@section('content')

<div class="container">
	<div class="page-header">
		<h1>Create new Item</h1>
	</div>
</div>

<div id="content" class="container">
	<form action="{{Asset('item/create-item')}}" method="post" id="form-register">
		<div class="row">
			<div class="form-group">
				<label for="category" class="col-sm-1 control-label">Category</label>
				<div class="col-sm-3">
					<select class="form-control" name="category" id="category">
					<option>-- Pick a category --</option>
					@foreach (Category::get() as $category)
						<option value="{{$category->id}}">{{$category->name}}</option>
					@endforeach
					</select>
				</div>
			</div>
		</div>
		<br>
		<div id="new_item_div">
		</div>
		<br/>
		<div class="row text-center">
		<button class="btn btn-primary" type="submit">Save New Item</button>
		<button class="btn btn-default" type="button" onclick="window.history.back()">Back</button>
	</div>
	</form>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#category').change(function(){
			category_id = $(this).val();
			$.ajax({
					url: '{{asset('item/pick-category')}}',
					type: 'post',
					data: {category_id: category_id},
					success: function (data) {
						$('#new_item_div').html(data);
					}
				});
		});
	});

</script>

@endsection