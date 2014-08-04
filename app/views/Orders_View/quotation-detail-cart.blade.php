@if(Cache::has('quotationDetailCart'))
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
?>
@foreach (Cache::get('quotationDetailCart') as $key => $quotationDetail)
<tr>
	<td rowspan="3">{{$quotationDetail->orderProduct->name}}</td>
	<td>
		<input type="text" name="price" class="inputPrice" id="{{$key}}" value="{{number_format($quotationDetail->price, 0, '.', ',')}}" size="8" style="text-align: right"> VND
	</td>
	<td class="text-center" rowspan="3">
		<input type="text" name="quantity" class="inputQuantity" id="{{$key}}" value="{{$quotationDetail->quantity}}" size="3" style="text-align: center">
	</td>
	<td class="text-center">{{number_format($quotationDetail->price*$quotationDetail->quantity, 0, '.', ',')}} VND</td>
	<td rowspan="3"><button type="button" class="btn btn-link delete-quotationDetail-button" id="{{$key}}">Del</button></td>
</tr>
<tr>
	<td>
		<input type="text" name="price_usd" class="inputPrice_usd" id="{{$key}}" value="{{number_format($quotationDetail->price_usd, 4, '.', ',')}}" size="8" style="text-align: right"> USD
	</td>
	<td class="text-center">{{number_format($quotationDetail->price_usd*$quotationDetail->quantity, 4, '.', ',')}} USD</td>
</tr>
<tr>
	<td>
		<input type="text" name="price_jpy" class="inputPrice_jpy" id="{{$key}}" value="{{number_format($quotationDetail->price_jpy, 2, '.', ',')}}" size="8" style="text-align: right"> JPY
	</td>
	<td class="text-center">{{number_format($quotationDetail->price_jpy*$quotationDetail->quantity, 2, '.', ',')}} JPY</td>
</tr>
@endforeach

<script>
	// Delete Order Detail
	$('.delete-quotationDetail-button').click(function(){
		key = $(this).attr('id');
		$.ajax({
			url: '{{asset("orders/quotation-product-handle-cache")}}',
			type: 'POST',
			data: {key: key, type: 2},
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

	// Change Price Quotation Product
	$('.inputPrice').change(function() {
		product_price = $(this).val();
		key           = $(this).attr('id');

		$.ajax({
			url: '{{asset("orders/quotation-product-handle-cache")}}',
			type: 'post',
			data: {type: 3, product_price: product_price, key: key},
		})
		.done(function(data) {
			$('#table-order-product').html(data);
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	});

	// Change PriceUSD Quotation Product
	$('.inputPrice_usd').change(function() {
		product_price_usd = $(this).val();
		key               = $(this).attr('id');

		$.ajax({
			url: '{{asset("orders/quotation-product-handle-cache")}}',
			type: 'post',
			data: {type: 3, product_price_usd: product_price_usd, key: key},
		})
		.done(function(data) {
			$('#table-order-product').html(data);
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	});

	// Change PriceUSD Quotation Product
	$('.inputPrice_jpy').change(function() {
		product_price_jpy = $(this).val();
		key               = $(this).attr('id');

		$.ajax({
			url: '{{asset("orders/quotation-product-handle-cache")}}',
			type: 'post',
			data: {type: 3, product_price_jpy: product_price_jpy, key: key},
		})
		.done(function(data) {
			$('#table-order-product').html(data);
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	});

	// Change Quantity Quotation Product
	$('.inputQuantity').change(function() {
		product_quantity = $(this).val();
		key              = $(this).attr('id');

		$.ajax({
			url: '{{asset("orders/quotation-product-handle-cache")}}',
			type: 'post',
			data: {type: 3, product_quantity: product_quantity, key: key},
		})
		.done(function(data) {
			$('#table-order-product').html(data);
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

@endif