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
		@foreach ($quotationDetails as $quotationDetail)
		<tr>
			<td>{{++$no}}</td>
			<td>{{$quotationDetail->orderProduct->name}}</td>
			<td>{{number_format($quotationDetail->price, 0, '.', ',')}}</td>
			<td>{{$quotationDetail->quantity}}</td>
			<td>{{number_format($quotationDetail->price*$quotationDetail->quantity, 0, '.', ',')}}</td>
		</tr>
		<?php $sum += $quotationDetail->price*$quotationDetail->quantity; ?>
		@endforeach
		<tr>
			<td colspan="4"></td>
			<td>{{number_format($sum, 0, '.', ',')}}</td>
		</tr>
	</tbody>
</table>