<div class="row">
	<div class="col-sm-12">
		<table class="table table-responsive table-striped table-condensed">
			<tr>
				<th>No</th>
				<th>Date</th>
				<th>Item name</th>
				<th>Type</th>
				<th>Amount</th>
				<th>Note</th>
				<th class="text-center">Action</th>
			</tr>
			<?php $no=0; ?>
			@foreach ($transactions as $transaction)
			<tr>
				<td>{{++$no}}</td>
				<td>{{$transaction->date}}</td>
				<td>{{$transaction->item->getItemName()}}</td>
				<td>@if ($transaction->type == "I") Import @else Export @endif</td>
				<td>{{$transaction->amount}}</td>
				<td>{{$transaction->note}}</td>
				<td class="text-centers">
					<button type="button" class="btn btn-link delete_button" id="{{$transaction->id}}" data-toggle="modal" data-target="#myModal">Del</button>
					<a href="{{Asset('inventory/modify/'.$transaction->id)}}"><button type="button" class="btn btn-link">Modify</button></a>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
</div>

<!-- Modal -->
<form action="{{Asset('inventory/delete-transaction')}}" method="post">
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">Delete transaction</h4>
	      </div>
	      <div class="modal-body">
	        Are you sure delete this transaction?
	        <input type="hidden" id="transaction_id" name="transaction_id">
	      </div>
	      <div class="modal-footer">
	        <div class="row">
	        	<div class="col-sm-5">
	        		<button type="submit" id="del_confirm" class="btn btn-primary btn-block">Delete Transaction</button>
	        	</div>
	        	<div class="col-sm-3">
	        		<button type="button" class="btn btn-default btn-block" data-dismiss="modal">Close</button>
	        	</div>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
</form>

<script>
	// Javascript for delete button

	$('.delete_button').click(function(){
		transaction_id = $(this).attr('id');
		$('#transaction_id').val(transaction_id);
	});

	
</script>