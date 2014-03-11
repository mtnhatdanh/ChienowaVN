<div class="col-sm-8 form-group">
	<label for="lookup_item_select" class="control-label">Pick an Item</label>
	<select name="lookup_item_select" id="lookup_item_select" class="form-control" size="10">
		@foreach ($items as $item)
		<option value="{{$item->id}}">{{$item->getItemName()}}</option>
		@endforeach
	</select>
</div>