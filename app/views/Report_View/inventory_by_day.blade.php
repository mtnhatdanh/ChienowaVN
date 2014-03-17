@extends('theme')

@section('title')
Chienowa Vietnam - Report Inventory
@endsection
@section('content')

<div class="container">
	<div class="page-header">
		<h1>Report Inventory by day</h1>
	</div>
</div>
<br/>

<div id="content" class="container">
	<form action="{{Asset('excel-export/inventory-by-day')}}" method="post" id="filter_form">
		<div class="form-inline">
			<div class="row">
				<div class="form-group col-sm-3">
					<label for="category_id" class="control-label">Category</label>
					<select type="category_id" class="form-control" id="category_id" name="category_id">
						@foreach (Category::get() as $category)
						<option value="{{$category->id}}">{{$category->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-sm-3">
					<label for="from_day" class="control-label">From day</label>
					<input type="date" class="form-control" id="from_day" name="from_day">
				</div>
				<div class="form-group col-sm-3">
					<label for="to_day" class="control-label">To day</label>
					<input type="date" class="form-control" id="to_day" name="to_day">
				</div>
				<div class="col-sm-2">
					<button class="btn btn-default btn-block" type="button" id="filter_button">Filter</button>
				</div>
			</div>
		</div>
	</form>
	<br/>
	<div id="result_div"></div>
	
	
</div>

<script type="text/javascript">
	$(document).ready(function(){

		// Ajax for filter
		$('#filter_button').click(function(){
			category_id = $('#category_id').val();
			from_day    = $('#from_day').val();
			to_day      = $('#to_day').val();
			if(from_day == "" || to_day == "" || from_day > to_day) alert('Wrong Input!!');
			else {
				$.ajax({
						url: '{{Asset('report/inventory-filter')}}',
						type: 'post',
						data: {category_id: category_id, from_day: from_day, to_day: to_day},
						success: function (data) {
							$('#result_div').html(data);
						}
					});
			}
		});
	});
</script>

@endsection