@if(Cache::has('orderDetailCart'))
<tr>
	<th>Name</th>
	<th>Price</th>
	<th class="text-center">Quantity</th>
	<th>Total</th>
	<th>Action</th>
</tr>
<?php $sum = 0;?>
@foreach (Cache::get('orderDetailCart') as $orderProduct_id => $orderDetail)
<tr>
	<td>{{OrderProduct::find($orderProduct_id)->name}}</td>
	<td>{{number_format($orderDetail->price, 0, '.', ',')}}</td>
	<td class="text-center">{{$orderDetail->quantity}}</td>
	<td>{{number_format($orderDetail->price*$orderDetail->quantity, 0, '.', ',')}}</td>
	<td><button type="button" class="btn btn-link delete-orderDetail-button" id="{{$orderProduct_id}}">Del</button></td>
</tr>
<?php $sum+= $orderDetail->price*$orderDetail->quantity?>
@endforeach
<tr>
	<td colspan="3"></td>
	<td>{{number_format($sum, 0, '.', ',')}}</td>
	<td></td>
</tr>
<script>
	// Delete Order Detail
	$('.delete-orderDetail-button').click(function(){
		order_product_id = $(this).attr('id');
		$.ajax({
			url: '{{asset("orders/order-product-handle-cache")}}',
			type: 'POST',
			data: {order_product_id: order_product_id, type: 2},
		})
		.done(function(data) {
			console.log("success");
			$('#table-order-product').html(data);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	});	
</script>

@endif