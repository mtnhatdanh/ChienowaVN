<div class="container">
	<span>Chienowa Vietnam</span><br/>
	<span>281 Nguyen Thien Thuat St | Dist 3 | HCMC | Vietnam</span><br/>
</div>
<div class="container"><span><strong>From day:</strong> {{date('m-d-Y', strtotime($from_day))}} <strong>to day: </strong>{{date('m-d-Y', strtotime($to_day))}}</span></div>
<div class="container">
	<h1>Report Inventory</h1>
</div>
<br/>


<div class="container">
	<table class="table table-responsive table-striped table-condensed">
		<tr>
			<th class="hidden-xs text-center">No</th>
			<th>Name</th>
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
			<td class="hidden-xs">{{$item->getItemUnit()}}</td>
			<td class="hidden-xs">{{$openingStock}}</td>
			<td>{{$arrayAmount['sumImport']}}</td>
			<td>{{$arrayAmount['sumExport']}}</td>
			<td class="hidden-xs">{{$openingStock+$arrayAmount['inStock']}}</td>
			<td class="hidden-xs">{{$inStock['inStock']}}</td>
		</tr>
		@endforeach
	</table>
</div>

<div class="container">
	<span class="text-muted">Copyright &copy; 2014, Chienowa Co., Ltd</span><br/>
	<span class="text-muted">Design by Minh Giang</span><br/>
	<span class="text-muted">Mail to: minh@chienowa.agri-wave.com</span>
</div>