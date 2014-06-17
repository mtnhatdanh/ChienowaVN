<table class="table table-responsive">
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
		<?php $no = 0; $sum = 0;?>
		@foreach ($orderDetails as $orderDetail)
		<tr>
			<td>{{++$no}}</td>
			<td>{{$orderDetail->orderProduct->name}}</td>
			<td>{{number_format($orderDetail->price, 0, '.', ',')}}</td>
			<td>{{$orderDetail->quantity}}</td>
			<td>{{number_format($orderDetail->price*$orderDetail->quantity, 0, '.', ',')}}</td>
		</tr>
		<?php $sum += $orderDetail->price*$orderDetail->quantity; ?>
		@endforeach
		<tr>
			<td colspan="4"></td>
			<td>{{number_format($sum, 0, '.', ',')}}</td>
		</tr>
	</tbody>
</table>