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
		{{Former::text('main_product')->class('form-control')->placeholder('Main Product')}}
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
<br/>
<div class="row">
	<div class="col-sm-4">
		<strong>Rating</strong><br/>
		<span class="rating">
		    <input type="radio" class="rating-input"
		        id="rating-input-3-5" name="rating" value="5" @if ($supplier->rating == 5) checked @endif>
		    <label for="rating-input-3-5" class="rating-star"></label>
		    <input type="radio" class="rating-input"
		        id="rating-input-3-4" name="rating"  value="4" @if ($supplier->rating == 4) checked @endif>
		    <label for="rating-input-3-4" class="rating-star"></label>
		    <input type="radio" class="rating-input"
		        id="rating-input-3-3" name="rating" value="3" @if ($supplier->rating == 3) checked @endif>
		    <label for="rating-input-3-3" class="rating-star"></label>
		    <input type="radio" class="rating-input"
		        id="rating-input-3-2" name="rating"  value="2" @if ($supplier->rating == 2) checked @endif>
		    <label for="rating-input-3-2" class="rating-star"></label>
		    <input type="radio" class="rating-input"
		        id="rating-input-3-1" name="rating" value="1" @if ($supplier->rating == 1) checked @endif>
		    <label for="rating-input-3-1" class="rating-star"></label>
		</span>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		{{Former::textarea('note')->class('form-control')->placeholder('Note')}}
	</div>
</div>