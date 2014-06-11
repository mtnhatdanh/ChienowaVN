<style>
	table#quotation-table td {
		vertical-align: middle;
	}
</style>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-responsive" id="quotation-table">
			<tr>
				<th>User</th>
				<th>Supplier</th>
				<th>Product</th>
				<th>Date</th>
				@if ($status == 1)
				<th class="text-center">Completed date</th>
				<th class="text-center">Used date</th>
				@endif
				<th class="text-center">Status</th>
			</tr>
			@foreach ($quotations as $quotation)
			<tr>
				<td>{{$quotation->user->name}}</td>
				<td>
					{{$quotation->supplier->name}}
					<button type="button" id="{{$quotation->supplier->id}}" class="btn btn-link info-button"><span class='glyphicon glyphicon-info-sign'></span></button>
				</td>
				<td>{{$quotation->product}}</td>
				<td>{{date('m-d-Y', strtotime($quotation->date))}}</td>

				@if ($quotation->status == 1)
				<td class="text-center">{{date('m-d-Y', strtotime($quotation->completed_date))}}</td>
				<?php
				$secs = strtotime($quotation->completed_date)-strtotime($quotation->date);
				$days = $secs/86400;
				?>
				<td class="text-center"><span class="label label-success">{{$days}}</span></td>
				@endif

				<td class="text-center">
					<?php
					$status = array('on-process', 'completed');
					?>
					<select name="status" class="status-select" id="{{$quotation->id}}">
						<option value="{{0}}" @if ($quotation->status == 0) selected @endif>{{$status[0]}}</option>
						<option value="{{1}}" @if ($quotation->status == 1) selected @endif>{{$status[1]}}</option>
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