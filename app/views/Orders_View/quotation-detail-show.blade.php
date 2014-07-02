<style>
	#quotationDetail-table td {
		vertical-align: middle;
	}
</style>
<table class="table table-responsive table-bordered" id="quotationDetail-table">
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
		@foreach ($quotationDetails as $quotationDetail)
		<tr>
			<td rowspan="3">{{++$no}}</td>
			<td rowspan="3">{{$quotationDetail->orderProduct->name}}</td>
			<td class="text-right">{{number_format($quotationDetail->price, 0, '.', ',')}} VND</td>
			<td rowspan="3" class="text-center">{{$quotationDetail->quantity}}</td>
			<td class='text-right'>{{number_format($quotationDetail->price*$quotationDetail->quantity, 0, '.', ',')}} VND</td>
		</tr>
		<tr>
			<td class="text-right">{{number_format($quotationDetail->price_usd, 2, '.', ',')}} USD</td>
			<td class="text-right">{{number_format($quotationDetail->price_usd*$quotationDetail->quantity, 2, '.', ',')}} USD</td>
		</tr>
		<tr>
			<td class="text-right">{{number_format($quotationDetail->price_jpy, 2, '.', ',')}} JPY</td>
			<td class="text-right">{{number_format($quotationDetail->price_jpy*$quotationDetail->quantity, 2, '.', ',')}} JPY</td>
		</tr>
		<?php 
		$sum += $quotationDetail->price*$quotationDetail->quantity;
		$sumUSD += $quotationDetail->price_usd*$quotationDetail->quantity; 
		$sumJPY += $quotationDetail->price_jpy*$quotationDetail->quantity; 
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