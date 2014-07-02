<style>
	#orderDetail-table td {
		vertical-align: middle;
	}
</style>
<table class="table table-responsive table-bordered" id="orderDetail-table">
	<thead>
		<tr>
			<th>No</th>
			<th>Product name</th>
			<th>Price</th>
			<th>Quantity</th>
			<th>Sum</th>
		</tr>
	</thead>
	<tbody>
		<?php $no = 0; $sum = 0; $sumUSD = 0; $sumJPY = 0;?>
		@foreach ($orderDetails as $orderDetail)
		<tr>
			<td rowspan="3">{{++$no}}</td>
			<td rowspan="3">{{$orderDetail->orderProduct->name}}</td>
			<td class="text-right">{{number_format($orderDetail->price, 0, '.', ',')}} VND</td>
			<td rowspan="3" class="text-center">{{$orderDetail->quantity}}</td>
			<td class="text-right">{{number_format($orderDetail->price*$orderDetail->quantity, 0, '.', ',')}} VND</td>
		</tr>
		<tr>
			<td class="text-right">{{number_format($orderDetail->price_usd, 2, '.', ',')}} USD</td>
			<td class="text-right">{{number_format($orderDetail->price_usd*$orderDetail->quantity, 2, '.', ',')}} USD</td>
		</tr>
		<tr>
			<td class="text-right">{{number_format($orderDetail->price_jpy, 2, '.', ',')}} JPY</td>
			<td class="text-right">{{number_format($orderDetail->price_jpy*$orderDetail->quantity, 2, '.', ',')}} JPY</td>
		</tr>
		<?php 
		$sum += $orderDetail->price*$orderDetail->quantity;
		$sumUSD += $orderDetail->price_usd*$orderDetail->quantity; 
		$sumJPY += $orderDetail->price_jpy*$orderDetail->quantity; 
		?>
		@endforeach
		<tr>
			<td colspan="5" class="text-center">Sum value</td>
		</tr>
		<tr>
			<td colspan="5" class="text-center"><strong>{{number_format($sum, 0, '.', ',')}}</strong> VND ~ <strong>{{number_format($sumUSD, 0, '.', ',')}}</strong> USD ~ <strong>{{number_format($sumJPY, 0, '.', ',')}}</strong> JPY</td>
		</tr>
	</tbody>
</table>