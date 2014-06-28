<style>
	#quotation-table td {
		vertical-align: middle;
	}
</style>
<div class="row">
	<div class="col-sm-12 text-center">
		<h3>{{strtoupper($supplier_name)}} <small>Supplier</small></h3>
	</div>
	<div class="col-sm-12">
		<table class="table table-responsive" id="quotation-table">
			<thead>
				<tr>
					<th>No</th>
					<th>Staff</th>
					<th class="text-center">Quotation Detail</th>
					<th>Date</th>
					<th>Completed date</th>
					<th class="text-center">Used date</th>
					<th>Status</th>
					<th>Note</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$no = 0;
				$status = array('on-process', 'completed');
				?>
				@foreach ($quotations as $quotation)
				<tr>
					<td>{{++$no}}</td>
					<td>{{$quotation->user->name}}</td>
					<td class="text-center">
						<button type="button" class="btn btn-link quotation-detail-button" data-toggle="modal" href='#quotation-detail-modal' id="{{$quotation->id}}">Quotation Detail</button>
					</td>
					<td>{{date('m-d-Y', strtotime($quotation->date))}}</td>
					<td>{{date('m-d-Y', strtotime($quotation->completed_date))}}</td>
					<?php
					$secs = strtotime($quotation->completed_date)-strtotime($quotation->date);
					$days = $secs/86400;
					?>
					<td class="text-center"><span class="label label-success">{{$days}}</span></td>
					<td>{{$status[$quotation->status]}}</td>
					<td>{{$quotation->note}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<!-- Quotation Detail modal -->
<div class="modal fade" id="quotation-detail-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Quotation Detail</h4>
			</div>
			<div class="modal-body">
				<div id="quotation-detail-div"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
	// Quotaion Detail button
	$('.quotation-detail-button').click(function(){
		quotation_id = $(this).attr('id');
		$.ajax({
			url: '{{asset("orders/quotation-detail-show")}}',
			type: 'POST',
			data: {quotation_id: quotation_id},
		})
		.done(function(data) {
			$('#quotation-detail-div').html(data);
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