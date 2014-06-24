@if(Cache::has('quotationDetailCart'))
<tr>
	<th>Name</th>
	<th>Price</th>
	<th class="text-center">Quantity</th>
	<th class="text-center">Total</th>
	<th>Action</th>
</tr>
<?php $sum = 0;?>
@foreach (Cache::get('quotationDetailCart') as $key => $quotationDetail)
<tr>
	<td>{{$quotationDetail->orderProduct->name}}</td>
	<td>
		<input type="text" name="price" class="inputPrice" id="{{$key}}" value="{{$quotationDetail->price}}" size="12" style="text-align: right">
	</td>
	<td class="text-center">
		<input type="text" name="quantity" class="inputQuantity" id="{{$key}}" value="{{$quotationDetail->quantity}}" size="4" style="text-align: center">
	</td>
	<td class="text-center">{{number_format($quotationDetail->price*$quotationDetail->quantity, 0, '.', ',')}}</td>
	<td><button type="button" class="btn btn-link delete-quotationDetail-button" id="{{$key}}">Del</button></td>
</tr>
<?php $sum+= $quotationDetail->price*$quotationDetail->quantity?>
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