<div class="row">
	@foreach($references as $reference)
	<div class="
	@if ($reference->attribute_id==1) col-sm-4 @else col-sm-2
	@endif" style="margin-bottom: 5px">
		<input type="text" class="form-control @if ($reference->attribute_id!=1 && $reference->attribute_id!=8) att_class @endif" 
		id="{{$reference->attribute_id}}" name="Att{{$reference->attribute_id}}" placeholder="{{$reference->attribute->name}}"
		@if ($reference->attribute_id==1) readonly @endif
		>
	</div>
	@endforeach
</div>
	


<script type="text/javascript">

	// jquery for name string
	$(document).ready(function(){
		$('.att_class').change(function(){
			var name_string = "{{Category::find($category_id)->code}}";
			$('.att_class').each(function(){
				if($(this).val()!="") name_string = name_string + '-' + $(this).val();
			});
			$('#1').val(name_string);
		});
	});

	$('#form-register').validate();
	$('.att_class').rules("add", {
		required: true,
	});



</script>