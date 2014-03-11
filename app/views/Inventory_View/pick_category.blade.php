<div class="row">
	<div class="form-group col-sm-4">
		<label for="attribute" class="control-label">Attribute</label>
		<select class="form-control"  name="attribute" id="attribute">
			<option>-- Pick a attribute --</option>
			@foreach($references as $reference)
			<option value="{{$reference->attribute_id}}">{{$reference->attribute->name}}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group col-sm-6">
		<label for="lookup_value" class="control-label">Lookup Value</label>
		<input type="text" class="form-control" name="lookup_value" id="lookup_value" placeholder="Lookup Value..">
	</div>
</div>
<div>
	<button class="btn btn-default" id="lookup_button">Lookup</button>
</div>
<br/>
<div class="row">
	<div id="result_lookup"></div>
</div>
	


<script type="text/javascript">

	// jquery for lookup item
	$('#lookup_button').click(function(){
		category_id = $('#category_name').val();
		attribute_id = $('#attribute').val();
		value = $('#lookup_value').val();
		$.ajax({
		 		url: '{{Asset('inventory/lookup-item')}}',
		 		type: 'post',
		 		data: {category_id: category_id, attribute_id: attribute_id, value:value},
		 		success: function (data) {
		 			$('#result_lookup').html(data);
		 		}
		 	}); 
	});
	
</script>