<!-- Quotaion Products Panel -->
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Project Items</h3>
	</div>
	<div class="panel-body">
	 	<div class="row">
	 		<div class="col-sm-12">
	 			{{Former::select('order_product')->fromQuery(OrderProduct::all(), 'name', 'id')->class('form-control')->id('order_product_id')->placeholder('-- Pick a Items --')}}
	 		</div>
	 	</div>
	 	<br/>
	 	<div class="row">
	 		<div class="col-sm-4 col-sm-offset-4">
	 			<button type="button" class="btn btn-default" id="add-product-button">Add item</button>
	 		</div>
	 	</div>
	</div>
	<!-- Table Order Product -->
	<table class="table table-responsive table-bordered" id="table-order-product">
		@include('Orders_View.project-detail-cart')
	</table>
</div>

<script>

	// Add product
	$('#add-product-button').click(function(){
		order_product_id        = $('#order_product_id').val();
		if (order_product_id == null) {
			alert('You have to pick a product first!!');
		} else {
			$.ajax({
				url: '{{asset("orders/project-product-handle-cache")}}',
				type: 'POST',
				data: {order_product_id: order_product_id, type: 1},
			})
			.done(function(data) {
				console.log("success");
				$('#table-order-product').html(data);
				$('#order_product_id').prop('selectedIndex', 0);
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