@if(Cache::has('projectDetailCart'))
<tr>
	<th>Name</th>
	<th>Action</th>
</tr>
@foreach (Cache::get('projectDetailCart') as $key=>$order_product_id)
<tr>
	<td>{{OrderProduct::find($order_product_id)->name}}</td>
	<td><button type="button" class="btn btn-link delete-quotationDetail-button" id="{{$key}}">Del</button></td>
</tr>
@endforeach

<script>
	// Delete Order Detail
	$('.delete-quotationDetail-button').click(function(){
		key = $(this).attr('id');
		$.ajax({
			url: '{{asset("orders/project-product-handle-cache")}}',
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
</script>

@endif