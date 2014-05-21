<br/>
<div class="row">
	<div class="col-sm-12">
		<label for="supplier-select" class="control-label">Pick a Supplier</label>
		<select name="supplier-select" id="supplier-select" class="form-control" size="10">
			@foreach ($suppliers as $supplier)
			<option value="{{$supplier->id}}">{{$supplier->name}}---{{$supplier->main_product}}---{{$supplier->repersentative}}---Rating: {{$supplier->rating}}</option>
			@endforeach
		</select>
	</div>
</div>