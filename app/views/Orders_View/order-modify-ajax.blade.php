{{Former::populate($order)}}
{{Former::hidden('order_id')->value($order->id)}}
<div class="row form-group">
	<div class="col-sm-3">
		{{Former::select('user_id')->options(array(Session::get('user')->id=>Session::get('user')->name))->label('User')->class('form-control')->disabled()}}
	</div>
	<div class="col-sm-3">
		{{Former::date('date')->class('form-control')->value(date('Y-m-d'))->disabled()}}
	</div>
	<div class="col-sm-6">
		<label for="supplier_name" class="control-label">Supplier name</label>
		<input type="text" id="supplier_name" class="form-control" value="{{$order->supplier->name}}" disabled>
	</div>
</div>
<div class="row form-group">
	<div class="col-sm-3">
		{{Former::text('order_product')->class('form-control')->disabled()}}
	</div>
	<div class="col-sm-3">
		{{Former::date('due_date')->class('form-control')->disabled()}}
	</div>
	<div class="col-sm-3">
		<?php
		$status = array('on-process', 'completed');
		?>
		{{Former::select('status')->options($status)->class('form-control')}}
	</div>
	<div class="col-sm-3">
		{{Former::date('delivery_date')->class('form-control')}}
	</div>
</div>
<div class="row form-group">
	<div class="col-sm-12">
		{{Former::textarea('note')->class('form-control')->placeholder('Note')}}
	</div>
</div>