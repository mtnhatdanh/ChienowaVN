@extends("theme")

@section('title')
Quality Control Report
@endsection

@section('content')

<div class="hidden-print">
	<div class="container">
		<div class="page-header">
			<h1>Quality Control Report</h1>
		</div>
	</div>
	<br/>
	
	<div id="content" class="container">
		<div class="form-inline row">
			<div class="form-group col-sm-3">
				<label for="from_day" class="control-label">From day</label>
				<input type="date" class="form-control" id="from_day" name="from_day">
			</div>
			<div class="form-group col-sm-3">
				<label for="to_day" class="control-label">To day</label>
				<input type="date" class="form-control" id="to_day" name="to_day">
			</div>
			<div class="form-group col-sm-3">
				<label for="inputProduct_id">Product</label>
				<select name="product_id" id="inputProduct_id" class="form-control" required="required">
					@foreach (Product::get() as $product)
					<option value="{{$product->id}}">{{$product->name}}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group col-sm-2">
				<button class="btn btn-default btn-block" type="button" id="filter_button" data-loading-text="Loading..">Filter</button>
			</div>
		</div>
		<br/>
		<div id="result_div"></div>
	</div>
</div>

<div class="visible-print" id="print_div"></div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#filter_button').click(function(){
			from_day = $('#from_day').val();
			to_day   = $('#to_day').val();
			if(from_day == "" || to_day == "" || from_day > to_day) alert('Input data is not valid!!');
			else {
				var btn=$(this);
				btn.button('loading');
				product_id = $('#inputProduct_id').val();
				$.ajax({
						url: '{{Asset('report/quality-control')}}',
						type: 'post',
						data: {from_day: from_day, to_day: to_day, product_id: product_id},
						success: function (data) {
							$('#result_div').html(data);
							btn.button('reset');
						}
					});
			}
		});
	});
</script>

@endsection