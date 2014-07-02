<!-- Script for google chart -->
<script type="text/javascript">
  google.setOnLoadCallback(drawChart);
  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Date', 'Price'],
      @foreach ($orderDetailTable as $orderDetail)
      ['{{date('m-d-Y', strtotime($orderDetail->date))}}',  {{$orderDetail->price_usd}}],
      @endforeach
    ]);

    var options = {
      title: 'Product Price (USD)',
      hAxis: {title: 'Date',  titleTextStyle: {color: '#333'}},
      vAxis: {minValue: 0}
    };

    var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
</script>

<style type="text/css">
	#order-detail-table td {
		vertical-align: middle;
	}
	#order-detail-table th {
		text-align: center;
	}
</style>


<div class="row">
	<div class="col-sm-12 text-center">
		<h3>{{OrderProduct::find($order_product_id)->name}} <small>Product</small></h3>
	</div>
	<div class="col-sm-12">
		<table class="table table-responsive table-bordered" id="order-detail-table">
			<thead>
				<tr>
					<th>No</th>
					<th>Date</th>
					<th>Price(VND)</th>
					<th>USD</th>
					<th>JPY</th>
					<th>Quantity</th>
					<th>Supplier</th>
				</tr>
			</thead>
			<tbody>
				<?php $no = 0;?>
				@foreach ($orderDetailTable as $orderDetail)
				<tr>
					<td class='text-center'>{{++$no}}</td>
					<td class="text-center">{{date('m-d-Y', strtotime($orderDetail->date))}}</td>
					<td class="text-right">{{number_format($orderDetail->price, 0, '.', ',')}}</td>
					<td class="text-right">{{number_format($orderDetail->price_usd, 2, '.', ',')}}</td>
					<td class="text-right">{{number_format($orderDetail->price_jpy, 2, '.', ',')}}</td>
					<td class="text-center">{{$orderDetail->quantity}}</td>
					<td>
						{{Supplier::find($orderDetail->supplier_id)->name}}
						<button type="button" id="{{$orderDetail->supplier_id}}" class="btn btn-link info-button"><span class='glyphicon glyphicon-info-sign'></span></button>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<div class="row">
	<div class="col-sm-8 col-sm-offset-2">
		<div id="chart_div"></div>
	</div>
</div>



<!-- Supplier infomation modal -->
<div class="modal fade" id="modal-info">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Supplier Infomation</h4>
			</div>
			<div class="modal-body">
				<div id="representative-info"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
	// Info button
	$('.info-button').click(function(){
		supplier_id = $(this).attr('id');
		$.ajax({
			url: '{{asset("orders/supplier-info")}}',
			type: 'post',
			data: {supplier_id: supplier_id},
		})
		.done(function(data) {
			console.log("success");
			$('#representative-info').html(data);
			$('#modal-info').modal('show');
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});

	});
</script>