<!-- Order Products Panel -->
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Order Products</h3>
	</div>
	<!-- get USD rate from Vietcombank -->
	<?php
	$rate = new Rate();
	$rate = $rate->showRateArray();
	$usdRate = $rate['USD'];
	$jpyRate = $rate['JPY'];
	?>
	<div class="panel-body">
		<div class="row">
			<div class="col-sm-4">
				USD rate: <span class="label label-info">{{number_format($usdRate, 0, '.', ',')}}</span>
			</div>
			<div class="col-sm-4">
				JPY rate: <span class="label label-info">{{number_format($jpyRate, 0, '.', ',')}}</span>
			</div>
		</div>
		<br/>
	 	<div class="row">
	 		<div class="col-sm-6">
	 			{{Former::select('order_product')->fromQuery(OrderProduct::all(), 'name', 'id')->class('form-control')->id('order_product_id')->placeholder('-- Pick a Product --')}}
	 		</div>
	 		<div class="col-sm-6">
	 			{{Former::text('quantity')->id('order_product_quantity')->class('form-control')->placeholder('Product Quantity..')}}
	 		</div>
	 		<div class="col-sm-4">
	 			{{Former::text('price')->id('order_product_price')->class('form-control')->placeholder('Product Price..')}}
	 		</div>
	 		<div class="col-sm-4">
	 			{{Former::text('price_in_usd')->id('order_product_price_usd')->class('form-control')->placeholder('Product USD Price..')}}
	 		</div>
	 		<div class="col-sm-4">
	 			{{Former::text('price_in_jpy')->id('order_product_price_jpy')->class('form-control')->placeholder('Product JPY Price..')}}
	 		</div>
	 	</div>
	 	<br/>
	 	<div class="row">
	 		<div class="col-sm-4 col-sm-offset-4">
	 			<button type="button" class="btn btn-default" id="add-product-button">Add product</button>
	 		</div>
	 	</div>
	</div>
	<!-- Table Order Product -->
	<table class="table table-responsive table-bordered" id="table-order-product">
		@include('Orders_View.order-detail-cart')
	</table>
</div>

<script>

	// convert from VND to USD
	$('#order_product_price').change(function(){
		priceVND = $(this).val();
		priceUSD = (priceVND/{{$usdRate}}).toFixed(2);
		priceJPY = (priceVND/{{$jpyRate}}).toFixed(2);
		$('#order_product_price_usd').val(priceUSD);
		$('#order_product_price_jpy').val(priceJPY);
	});

	// Add product
	$('#add-product-button').click(function(){
		order_product_id        = $('#order_product_id').val();
		order_product_price     = $('#order_product_price').val();
		order_product_price_usd = $('#order_product_price_usd').val();
		order_product_price_jpy = $('#order_product_price_jpy').val();
		order_product_quantity  = $('#order_product_quantity').val();
		if (order_product_id == 0 || order_product_price == 0 || order_product_quantity == 0 || order_product_price_usd == 0) {
			alert('Do not have enough data to add product!!');
		} else {
			$.ajax({
				url: '{{asset("orders/order-product-handle-cache")}}',
				type: 'POST',
				data: {order_product_id: order_product_id, order_product_price: order_product_price, order_product_quantity: order_product_quantity, order_product_price_usd: order_product_price_usd, order_product_price_jpy: order_product_price_jpy, type: 1},
			})
			.done(function(data) {
				console.log("success");
				$('#table-order-product').html(data);
				$('#order_product_id').prop('selectedIndex', 0);
				$('#order_product_price').val('');
				$('#order_product_price_usd').val('');
				$('#order_product_price_jpy').val('');
				$('#order_product_quantity').val('');
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
			
		}
	});

</script>