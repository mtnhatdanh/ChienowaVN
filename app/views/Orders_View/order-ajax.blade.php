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
			</tr>
			@foreach ($orders as $order)
			<tr>
				<td>{{$order->user->name}}</td>
				<td>
					{{$order->supplier->name}}
					<button type="button" id="{{$order->supplier->id}}" class="btn btn-link info-button"><span class='glyphicon glyphicon-info-sign'></span></button>
				</td>
				<td>{{$order->product}}</td>
				<td>{{$order->date}}</td>
				<td>{{$order->due_date}}</td>
				<?php
				$present_date = date('Y-m-d');
				$secs = strtotime($order->due_date)-strtotime($present_date);
				$days = $secs/86400;
				?>
				<td class="text-center"><span class="label @if ($days>0) label-success @else label-danger @endif">{{$days}}</span></td>
				<td class="text-center">
					<?php
					$status = array('on-process', 'completed');
					?>
					<select name="status" class="status-select" id="{{$order->id}}">
						<option value="{{0}}" @if ($order->status == 0) selected @endif>{{$status[0]}}</option>
						<option value="{{1}}" @if ($order->status == 1) selected @endif>{{$status[1]}}</option>
					</select>
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

<script type="text/javascript">
	$('.status-select').change(function(){
		quotation_id = $(this).attr('id');
		status       = $(this).val();
		$.ajax({
			url: '{{asset("orders/quotation-change-status")}}',
			type: 'POST',
			data: {quotation_id: quotation_id, status: status},
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	});

	// Info button
	$('.info-button').click(function(){
		supplier_id = $(this).attr('id');
		$.ajax({
				url: '{{asset('orders/supplier-info')}}',
				type: 'post',
				data: {supplier_id: supplier_id},
				success: function (data) {
					$('#representative-info').html(data);
					$('#modal-info').modal('show');
				}
			});

	});
</script>