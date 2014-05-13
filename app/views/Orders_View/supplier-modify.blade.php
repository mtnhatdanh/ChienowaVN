<?php 
Former::populate($supplier);
?>
{{Former::hidden('supplier_id')->value($supplier->id)}}
<div class="row">
	<div class="col-sm-4">
		{{Former::text('name')->class('form-control')->placeholder('Supplier name')}}
	</div>
	<div class="col-sm-4">
		{{Former::text('address')->class('form-control')->placeholder('Supplier address')}}
	</div>
	<div class="col-sm-4">
		{{Former::text('email')->class('form-control')->placeholder('Email')}}
	</div>
	<div class="col-sm-4">
		{{Former::text('phone')->class('form-control')->placeholder('Phone')}}
	</div>
	<div class="col-sm-4">
		{{Former::text('representative')->class('form-control')->placeholder('Repersentative')}}
	</div>
	<div class="col-sm-4">
		{{Former::text('mobile')->class('form-control')->placeholder('Mobile')}}
	</div>
	<div class="col-sm-4">
		{{Former::text('website')->class('form-control')->placeholder('Website')}}
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		{{Former::textarea('note')->class('form-control')->placeholder('Note')}}
	</div>
</div>