@extends('theme')

@section('title')
Chienowa Vietnam - Report Inventory
@endsection
@section('content')

<div class="container">
	<h1>Report Inventory</h1>
</div>
<br/>
<div class="container" id="content">
	<table class="table table-responsive table-striped">
		<tr>
			<th>No</th>
			<th>Name</th>
			<th>Infomation</th>
			<th>Unit</th>
			<th class="hidden-xs">Import</th>
			<th class="hidden-xs">Export</th>
			<th>In-Stock</th>
		</tr>
		<?php
		$category_number = 0;
		?>
		@foreach (Category::get() as $category)
		<tr class="info">
			<th>{{++$category_number}}.</th>
			<th>{{ucfirst($category->name)}}</th>
			<th></th>
			<th></th>
			<th class="hidden-xs"></th>
			<th class="hidden-xs"></th>
			<th></th>
		</tr>
		<?php $item_number = 0; ?>
		@foreach (Item::where('category_id', '=', $category->id)->get() as $item)
		<?php $inStockArray = $item->getInStock($item->id); ?>
		@if($inStockArray['inStock'])
		<tr>
			<td>{{$category_number}}.{{++$item_number}}</td>
			<td>{{$item->getItemName()}}</td>
			<td><button type="button" class="btn btn-link info_button" id="{{$item->id}}" data-toggle="modal" data-target="#myModal">Info</button></td>
			<td>{{$item->getItemUnit()}}</td>
			<td class="hidden-xs">{{$inStockArray['sumImport']}}</td>
			<td class="hidden-xs">{{$inStockArray['sumExport']}}</td>
			<td>{{$inStockArray['inStock']}}</td>
		</tr>
		@endif
		@endforeach
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

@endsection