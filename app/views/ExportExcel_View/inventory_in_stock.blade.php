<div class="container">
	<span>Chienowa Vietnam</span><br/>
	<span>281 Nguyen Thien Thuat St | Dist 3 | HCMC | Vietnam</span>
</div>
<div class="container">
	<h1>Report Inventory</h1>
</div>
<div class="container" id="content">
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-responsive table-striped table-condensed">
				<tr>
					<th class="hidden-xs">No</th>
					<th>Name</th>
					<th class="hidden-xs">Unit</th>
					<th class="hidden-xs">Import</th>
					<th class="hidden-xs">Export</th>
					<th>In-Stock</th>
				</tr>
				<?php
				$category_number = 0;
				?>
				@foreach (Category::get() as $category)
				<tr class="info">
					<th class="hidden-xs">{{++$category_number}}.</th>
					<th>{{ucfirst($category->name)}}</th>
					<th class="hidden-xs"></th>
					<th class="hidden-xs"></th>
					<th class="hidden-xs"></th>
					<th></th>
				</tr>
				<?php $item_number = 0; ?>
				@foreach (Item::where('category_id', '=', $category->id)->get() as $item)
				<?php $inStockArray = $item->getInStock(); ?>
				@if($inStockArray['inStock'])
				<tr>
					<td class="hidden-xs">{{$category_number}}.{{++$item_number}}</td>
					<td>{{$item->getItemName()}}</td>
					<td class="hidden-xs">{{$item->getItemUnit()}}</td>
					<td class="hidden-xs">{{$inStockArray['sumImport']}}</td>
					<td class="hidden-xs">{{$inStockArray['sumExport']}}</td>
					<td>{{$inStockArray['inStock']}}</td>
				</tr>
				@endif
				@endforeach
				@endforeach
			
			</table>
		</div>
	</div>
</div>
<div class="container">
	<span class="text-muted">Copyright &copy; 2014, Chienowa Co., Ltd</span><br/>
	<span class="text-muted">Design by Minh Giang</span><br/>
	<span class="text-muted">Mail to: minh@chienowa.agri-wave.com</span>
</div>