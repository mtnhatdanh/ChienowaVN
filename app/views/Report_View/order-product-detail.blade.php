@extends('theme')

@section('title')
Order Product Detail
@endsection
@section('content')

<!--Load the AJAX API-->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Year', 'Sales', 'Expenses'],
      ['2013',  1000,      400],
      ['2014',  1170,      460],
      ['2015',  660,       1120],
      ['2016',  1030,      540]
    ]);

    var options = {
      title: 'Company Performance',
      hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
      vAxis: {minValue: 0}
    };

    var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
</script>

<div class="container">
	<div class="page-header">
		<h1>Report Order Product Detail</h1>
	</div>
</div>
<br/>

<div id="content" class="container">
	<div class="form-inline">
		<div class="row">
			<div class="form-group col-sm-4">
				{{Former::select('order_product')->id('order_product_id')->fromQuery(OrderProduct::all(), 'name', 'id')->placeholder('-- Select order product --')->class('form-control')->label('Order Product')->inline()}}
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
				<button class="btn btn-default btn-block" type="button" id="filter_button" data-loading-text="Loading..">Filter</button>
			</div>
		</div>
	</div>
	<br/>
	<div id="result_div"></div>
	
</div>

<script type="text/javascript">
	$(document).ready(function(){

		// Ajax for filter
		$('#filter_button').click(function(){
			order_product_id = $('#order_product_id').val();
			from_day         = $('#from_day').val();
			to_day           = $('#to_day').val();
			if(from_day > to_day || order_product_id === null) alert('Wrong Input!!');
			else {
				var btn=$(this);
				btn.button('loading');
				$.ajax({
					url: '{{asset("report/order-product-detail")}}',
					type: 'POST',
					data: {order_product_id: order_product_id, from_day: from_day, to_day: to_day},
				})
				.done(function(data) {
					$('#result_div').html(data);
					btn.button('reset');
					google.setOnLoadCallback(drawChart());
					console.log("success");
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});
				
			}
		});
	});
</script>

@endsection