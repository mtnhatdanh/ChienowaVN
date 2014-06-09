<style>
	table#quotation-table td {
		vertical-align: middle;
	}
</style>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-responsive" id="order-table">
			<tr>
				<th>User</th>
				<th>Supplier</th>
				<th>Product</th>
				<th>Date</th>
				<th>Due Date</th>
				<th class="text-center">Over date</th>
				<th class="text-center">Status</th>
				<th class="text-center">Action</th>
			</tr>
			@foreach ($orders as $order)
			<tr>
				<td>{{$order->user->name}}</td>
				<td>
					{{$order->supplier->name}}
					<button type="button" id="{{$order->supplier->id}}" class="btn btn-link info-button"><span class='glyphicon glyphicon-info-sign'></span></button>
				</td>
				<td>{{$order->order_product}}</td>
				<td>{{$order->date}}</td>
				<td>{{$order->due_date}}</td>
				<?php
				$present_date = date('Y-m-d');
				$secs = strtotime($order->due_date)-strtotime($present_date);
				$days = $secs/86400;
				?>
				<td class="text-center"><span class="label @if ($days>0) label-success @else label-danger @endif">{{$days}}</span></td>
				<td class="text-center">@if ($order->status == 1) Completed @else On-process @endif</td>
				<td class="text-center">
					<button type="button" class="btn btn-default modify-button" id="{{$order->id}}" data-toggle="modal" href='#modify-modal'>Modify</button>
					<button type="button" class="btn btn-default delete-button" id="{{$order->id}}" data-toggle="modal" href='#delete-modal'>Delete</button>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
</div>

<!-- Supplier infomation modal -->
<div class="modal fade" id="modal-info">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Supplier Infomation</h4>
			</div>
			<div class="modal-body">
				<div id="representative-info"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Delete order modal -->
{{Former::open()->action(asset('orders/order-delete'))}}
<div class="modal fade" id="delete-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Delete order</h4>
			</div>
			<div class="modal-body">
				Are you sure to delete this order?
				{{Former::hidden('order_id')->id('order_id')}}
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Delete order</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{{Former::close()}}

<!-- Modify order modal -->
{{Former::open()->action(asset('orders/order-modify-confirm'))}}
<div class="modal fade bs-example-modal-lg" id="modify-modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Modify order</h4>
			</div>
			<div class="modal-body">
				<div id="modify-div"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save changes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{{Former::close()}}

<script type="text/javascript">

	// Info button
	$('.info-button').click(function(){
		supplier_id = $(this).attr('id');
		$.ajax({
			url: '{{asset("orders/supplier-info")}}',
			type: 'post',
			data: {supplier_id: supplier_id},
		})
		.done(function(data) {
			console.log("success");
			$('#representative-info').html(data);
			$('#modal-info').modal('show');
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});

	});

	// Delete button
	$('.delete-button').click(function(){
		order_id = $(this).attr('id');
		$('#order_id').val(order_id);
	});

	// Modify button
	$('.modify-button').click(function(){
		order_id = $(this).attr('id');
		$.ajax({
			url: '{{asset("orders/order-modify")}}',
			type: 'post',
			data: {order_id: order_id},
		})
		.done(function(data) {
			console.log("success");
			$('#modify-div').html(data);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	});
	
</script>