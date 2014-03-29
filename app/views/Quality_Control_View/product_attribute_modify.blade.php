<form action="{{Asset('quality-control/confirm-product-modify-attribute/'.$productAtt->id)}}" method="post" id="modify_form">
	<div class="form-group">
		<label for="name" class="control-label">Attribute Name</label>
		<input type="text" class="form-control" name="name" id="name" placeholder="Product Name.." value="{{$productAtt->name}}">
	</div>
	<div class="form-group">
		<label for="type" class="control-label">Type</label>
		<input type="text" class="form-control" name="type" id="type" placeholder="Type.." value="{{$productAtt->type}}">
	</div>
	<div class="form-group">
		<label for="order_no" class="control-label">Order Number</label>
		<input type="text" class="form-control" name="order_no" id="order_no" placeholder="Order Number.." value="{{$productAtt->order_no}}">
	</div>
</form>