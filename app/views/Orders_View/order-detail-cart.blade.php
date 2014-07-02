@if(Cache::has('orderDetailCart'))
<tr>
	<th>Name</th>
	<th class='text-center'>Price</th>
	<th class="text-center">Quantity</th>
	<th class="text-center">Total</th>
	<th>Action</th>
</tr>
<?php 
$sum = 0;
$sumUSD = 0;
$sumJPY = 0;
?>
@foreach (Cache::get('orderDetailCart') as $orderProduct_id => $orderDetail)
<tr>
	<td rowspan="3">{{OrderProduct::find($orderProduct_id)->name}}</td>
	<td>{{number_format($orderDetail->price, 0, '.', ',')}}</td>
	<td class="text-center" rowspan="3">{{$orderDetail->quantity}}</td>
	<td>{{number_format($orderDetail->price*$orderDetail->quantity, 0, '.', ',')}} VND</td>
	<td rowspan="3"><button type="button" class="btn btn-link delete-orderDetail-button" id="{{$orderProduct_id}}">Del</button></td>
</tr>
<tr>
	<td>{{number_format($orderDetail->price_usd, 2, '.', ',')}}</td>
	<td>{{number_format($orderDetail->price_usd*$orderDetail->quantity, 2, '.', ',')}} USD</td>
</tr>
<tr>
	<td>{{number_format($orderDetail->price_jpy, 2, '.', ',')}}</td>
	<td>{{number_format($orderDetail->price_jpy*$orderDetail->quantity, 2, '.', ',')}} JPY</td>
</tr>
<?php 
$sum+= $orderDetail->price*$orderDetail->quantity;
$sumUSD+= $orderDetail->price_usd*$orderDetail->quantity;
$sumJPY+= $orderDetail->price_jpy*$orderDetail->quantity;
?>
@endforeach
<tr>
	<td colspan="5" class="text-center"><strong>Sum value</strong></td>
</tr>
<tr>
	<td colspan="5" class="text-center"><strong>{{number_format($sum, 0, '.', ',')}}</strong> VND ~ <strong>{{number_format($sumUSD, 2, '.', ',')}}</strong> USD ~ <strong>{{number_format($sumJPY, 2, '.', ',')}}</strong> JPY</td>
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