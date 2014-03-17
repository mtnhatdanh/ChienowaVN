<div class="row">
	<div class="col-sm-12">
		<table class="table table-responsive table-condensed table-striped">
			<tr>
				<th class="hidden-xs">No</th>
				<th>Date</th>
				<th>Item</th>
				<th class="hidden-xs">Information</th>
				<th>Type</th>
				<th>Amount</th>
				<th class="hidden-xs">Unit</th>
			</tr>
			<?php $no = 0;?>
			@foreach ($transactions as $transaction)
			<tr>
				<td class="hidden-xs">{{++$no}}</td>
				<td>{{date('m-d-Y', strtotime($transaction->date))}}</td>
				<td>{{$transaction->item->getItemName()}}</td>
				<td class="hidden-xs">
					<button type="button" class="btn btn-link info_button" id="{{$transaction->item->id}}" data-toggle="modal" data-target="#myModal">Info</button>
				</td>
				<td>@if ($transaction->type == 'I') Import @else Export @endif</td>
				<td>
					<button class="btn btn-link note_button" data-container="body" data-toggle="popover" data-placement="left" data-content="{{$transaction->note}}" data-original-title="Note">{{$transaction->amount}}</button>
				</td>
				<td class="hidden-xs">{{$transaction->item->getItemUnit()}}</td>
			</tr>
			@endforeach
		</table>
	</div>
</div>

<div class="row">
	<div class="col-sm-2">
		<button class="btn btn-default btn-block" id="export_button">Export to Excel file..</button>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Attributes</h4>
      </div>
      <div class="modal-body">
      	<div id="info_div"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
	$(document).ready(function(){

		$('.note_button').popover();
		//Ajax for info button
		$('.info_button').click(function(){
			item_id = $(this).attr('id');
			$.ajax({
					url: '{{Asset('data/item-info')}}',
					type: 'post',
					data: {item_id: item_id},
					success: function (data) {
						$('#info_div').html(data);
					}
				});
		});

		// Export Excel file button
		$('#export_button').click(function(){
			from_day    = $('#from_day').val();
			to_day      = $('#to_day').val();
			if(from_day == "" || to_day == "" || from_day > to_day) alert('Wrong Input!!');
			else {
				$('#filter_form').submit();
			}
		});


	});
</script>