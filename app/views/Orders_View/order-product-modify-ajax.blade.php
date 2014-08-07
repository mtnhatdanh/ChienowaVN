<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
		<label for="inputName">Product Name</label>
		<input type="text" name="name" id="inputName" class="form-control" value="{{$orderProduct->name}}" required="required">
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
		<label for="inputNote">Note</label>
		<input type="text" name="note" id="inputNote" class="form-control" value="{{$orderProduct->note}}" required="required">
	</div>
	<input type="hidden" name="orderProduct_id" value="{{$orderProduct->id}}">
</div>