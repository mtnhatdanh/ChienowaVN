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
				<th class="text-center">Quotation Detail</th>
				<th>Date</th>
				@if ($status == 1)
				<th class="text-center">Completed date</th>
				<th class="text-center">Used date</th>
				@endif
				<th class="text-center">Status</th>
				<th class="text-center">Action</th>
			</tr>
			@foreach ($quotations as $quotation)
			<tr>
				<td>{{$quotation->user->name}}</td>
				<td>
					{{$quotation->supplier->name}}
					<button type="button" id="{{$quotation->supplier->id}}" class="btn btn-link info-button"><span class='glyphicon glyphicon-info-sign'></span></button>
				</td>
				<td class="text-center">
					<button type="button" class="btn btn-link quotation-detail-button" data-toggle="modal" href='#quotation-detail-modal' id="{{$quotation->id}}">Quotation Detail</button>
				</td>
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
					{{$status[$quotation->status]}}
				</td>
				<td class="text-center">
					<a href="{{asset("orders/quotation-modify/".$quotation->id)}}"><button type="button" class="btn btn-default modify-button">Modify</button></a>
					<button type="button" class="btn btn-default delete-button" id="{{$quotation->id}}" data-toggle="modal" href='#delete-modal'>Delete</button>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
</div>

<!-- Delete order modal -->
{{Former::open()->action(asset('orders/quotation-delete'))}}
<div class="modal fade" id="delete-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Delete quotation</h4>
			</div>
			<div class="modal-body">
				Are you sure to delete this quotation?
				{{Former::hidden('quotation_id')->id('quotation_id')}}
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Delete quotation</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{{Former::close()}}

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
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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

	// Delete button
	$('.delete-button').click(function(){
		quotation_id = $(this).attr('id');
		$('#quotation_id').val(quotation_id);
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