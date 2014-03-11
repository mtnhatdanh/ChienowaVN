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
			<th>Unit</th>
			<th>Import</th>
			<th>Export</th>
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
			<th></th>
			<th></th>
		</tr>
		<?php $item_number = 0; ?>
		@foreach (Item::where('category_id', '=', $category->id)->get() as $item)
		<?php $inStockArray = $item->getInStock($item->id); ?>
		@if($inStockArray['inStock'])
		<tr>
			<td>{{$category_number}}.{{++$item_number}}</td>
			<td>{{$item->getItemName()}}</td>
			<td>{{$item->getItemUnit()}}</td>
			<td>{{$inStockArray['sumImport']}}</td>
			<td>{{$inStockArray['sumExport']}}</td>
			<td>{{$inStockArray['inStock']}}</td>
		</tr>
		@endif
		@endforeach
		@endforeach

	</table>
</div>

@endsection