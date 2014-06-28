<style>
	#order-table td {
		vertical-align: middle;
	}
</style>
<div class="row">
	<div class="col-sm-12 text-center">
		<h3>{{strtoupper($supplier_name)}} <small>Supplier</small></h3>
	</div>
	<div class="col-sm-12">
		<table class="table table-responsive" id="order-table">
			<thead>
				<tr>
					<th>No</th>
					<th>Staff</th>
					<th class="text-center">Order Detail</th>
					<th>Date</th>
					<th>Due date</th>
					<th>Delivery date</th>
					<th class="text-center">Late date</th>
					<th>Status</th>
					<th>Note</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$no = 0;
				$status = array('on-process', 'completed');
				?>
				@foreach ($orders as $order)
				<tr>
					<td>{{++$no}}</td>
					<td>{{$order->user->name}}</td>
					<td class="text-center"><button type="button" class="btn btn-link order-product-button" id="{{$order->id}}" data-toggle="modal" href='#order-products-modal'>Order Products</button></td>
					<td>{{date('m-d-Y', strtotime($order->date))}}</td>
					<td>{{date('m-d-Y', strtotime($order->due_date))}}</td>
					<td>{{date('m-d-Y', strtotime($order->delivery_date))}}</td>
					<?php
					$secs = strtotime($order->delivery_date)-strtotime($order->due_date);
					$days = $secs/86400;
					?>
					<td class="text-center">
						<span class="label @if ($days>0) label-danger @else label-success @endif">{{$days}}</span>
					</td>
					<td>{{$status[$order->status]}}</td>
					<td>{{$order->note}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<!-- Order Products modal -->
<div class="modal fade" id="order-products-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Modal title</h4>
			</div>
			<div class="modal-body">
				<div id="order-products-result"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
	// Order Products button
	$('.order-product-button').click(function(){
		order_id = $(this).attr('id');
		$.ajax({
			url: '{{asset("orders/order-product-show")}}',
			type: 'post',
			data: {order_id: order_id},
		})
		.done(function(data) {
			$('#order-products-result').html(data);
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	});
</script>