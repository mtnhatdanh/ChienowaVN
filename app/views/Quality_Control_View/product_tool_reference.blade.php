@extends("theme")

@section('title')
Tool Reference
@endsection

@section('content')

<div class="container">
	<div class="page-header">
		<h1>{{ucfirst($product->name)}} - Tool Reference</h1>
	</div>
	@include('notification')
</div>
<div id="content" class="container">
	<form action="{{Asset('quality-control/tool-reference/'.$product->id)}}" method="post">
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-responsive table-bordered table-condensed">
					<tr>
						<th>No</th>
						<th>Product Attribute</th>
						<th>Item</th>
						<th>Inspection tool</th>
					</tr>
					<?php $no=0; ?>
					@foreach ($productRefs as $productRef)
					<?php
					$toolRef = ToolRef::where('product_ref_id', '=', $productRef->id)->first();
					?>
					<tr>
						<td>{{++$no}}</td>
						<td>{{$productRef->name}}</td>
						<td>
							<input type="hidden" name="product_ref_id[]" value="{{$productRef->id}}">
							<input type="text" name="item[]" id="inputItem" class="form-control" required="required" placeholder="Item" value="@if ($toolRef) {{$toolRef->item}} @endif">
						</td>
						<td>
							<select name="equipment_id[]" id="inputEquipment_id" class="form-control" required="required">
								@foreach (Equipment::get() as $equipment)
								<option value="{{$equipment->id}}" @if ($toolRef && $toolRef->equipment_id == $equipment->id) selected @endif>{{$equipment->name}}</option>
								@endforeach
							</select>
						</td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2">
				<button type="submit" class="btn btn-block btn-primary hidden-xs">Save</button>
			</div>
			<div class="col-sm-2">
				<a href="{{Asset('quality-control/product-list')}}"><button class="btn btn-block btn-default" type="button">Back</button></a>
			</div>
		</div>
	</form>
</div>

@endsection