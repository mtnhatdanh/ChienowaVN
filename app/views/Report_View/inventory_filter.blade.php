<div class="container">
	<table class="table table-responsive table-striped">
		<tr>
			<th>No</th>
			<th>Name</th>
			<th>Infomation</th>
			<th>Unit</th>
			<th>Opening stock</th>
			<th class="hidden-xs">Import</th>
			<th class="hidden-xs">Export</th>
			<th>Closing stock</th>
			<th>In-Stock</th>
		</tr>
		<?php $item_no = 0;?>
		@foreach ($items as $item)
		<?php 
		$arrayAmount = Item::getAmountFilterByDay($item->id, $from_day, $to_day);
		$openingStock = Item::getOpeningStock($item->id, $from_day);
		$inStock = Item::getInStock($item->id);
		?>
		<tr>
			<td>{{++$item_no}}</td>
			<td>{{$item->getItemName()}}</td>
			<td><button type="button" class="btn btn-link info_button" id="{{$item->id}}" data-toggle="modal" data-target="#myModal">Info</button></td>
			<td>{{$item->getItemUnit()}}</td>
			<td>{{$openingStock}}</td>
			<td>{{$arrayAmount['sumImport']}}</td>
			<td>{{$arrayAmount['sumExport']}}</td>
			<td>{{$openingStock+$arrayAmount['inStock']}}</td>
			<td>{{$inStock['inStock']}}</td>
		</tr>
		@endforeach
	</table>
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
        <div class="container">
        	<div id="info_div"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
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
	});
</script>