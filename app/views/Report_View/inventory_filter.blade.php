<table class="table table-responsive table-striped table-condensed">
	<tr>
		<th class="hidden-xs text-center">No</th>
		<th>Name</th>
		<th class="text-center">Infomation</th>
		<th class="hidden-xs">Unit</th>
		<th class="hidden-xs">Opening stock</th>
		<th>Import</th>
		<th>Export</th>
		<th class="hidden-xs">Closing stock</th>
		<th class="hidden-xs">In-Stock</th>
	</tr>
	<?php $item_no = 0;?>
	@foreach ($items as $item)
	<?php 
	$arrayAmount  = Item::getAmountFilterByDay($item->id, $from_day, $to_day);
	$openingStock = Item::getOpeningStock($item->id, $from_day);
	$inStock      = $item->getInStock();
	?>
	<tr>
		<td class="hidden-xs text-center">{{++$item_no}}</td>
		<td>{{$item->getItemName()}}</td>
		<td class="text-center">
			<button type="button" class="btn btn-link info_button" id="{{$item->id}}" data-toggle="modal" data-target="#myModal">Info</button>
			<button type="button" class="btn btn-link trans_button" id="{{$item->id}}" data-toggle="modal" data-target="#myTransactions">Trans</button>
		</td>
		<td class="hidden-xs">{{$item->getItemUnit()}}</td>
		<td class="hidden-xs">{{$openingStock}}</td>
		<td>{{$arrayAmount['sumImport']}}</td>
		<td>{{$arrayAmount['sumExport']}}</td>
		<td class="hidden-xs">{{$openingStock+$arrayAmount['inStock']}}</td>
		<td class="hidden-xs">{{$inStock['inStock']}}</td>
	</tr>
	@endforeach
</table>

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

<!-- Modal for Transactions Detail -->
<div class="modal fade bs-example-modal-lg" id="myTransactions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Transactions</h4>
      </div>
      <div class="modal-body">
    	<div id="transaction_div"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
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

		// Ajax for Trans button
		$('.trans_button').click(function(){
			item_id  = $(this).attr('id');
			from_day = $('#from_day').val();
			to_day   = $('#to_day').val();
			$.ajax({
					url: '{{Asset('data/transaction-byday')}}',
					type: 'post',
					data: {item_id: item_id, from_day: from_day, to_day:to_day},
					success: function (data) {
						$('#transaction_div').html(data);
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