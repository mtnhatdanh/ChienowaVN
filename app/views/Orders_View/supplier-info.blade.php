<div class="row">
	<div class="col-sm-4">
		<strong>Name</strong>
	</div>
	<div class="col-sm-8">
		{{$supplier->name}}
	</div>
</div>
<div class="row">
	<div class="col-sm-4">
		<strong>Main Products</strong>
	</div>
	<div class="col-sm-8">
		{{$supplier->main_product}}
	</div>
</div>
<div class="row">
	<div class="col-sm-4">
		<strong>Address</strong>
	</div>
	<div class="col-sm-8">
		{{$supplier->address}}
	</div>
</div>
<div class="row">
	<div class="col-sm-4">
		<strong>Email</strong>
	</div>
	<div class="col-sm-8">
		{{$supplier->email}}
	</div>
</div>
<div class="row">
	<div class="col-sm-4">
		<strong>Phone</strong>
	</div>
	<div class="col-sm-8">
		{{$supplier->phone}}
	</div>
</div>
<div class="row">
	<div class="col-sm-4">
		<strong>Representative</strong>
	</div>
	<div class="col-sm-8">
		{{$supplier->representative}}
	</div>
</div>
<div class="row">
	<div class="col-sm-4">
		<strong>Mobile</strong>
	</div>
	<div class="col-sm-8">
		{{$supplier->mobile}}
	</div>
</div>
<div class="row">
	<div class="col-sm-4">
		<strong>Website</strong>
	</div>
	<div class="col-sm-8">
		{{$supplier->website}}
	</div>
</div>
<div class="row">
	<div class="col-sm-4">
		<strong>Note</strong>
	</div>
	<div class="col-sm-8">
		{{$supplier->note}}
	</div>
</div>
<div class="row">
	<div class="col-sm-4">
		<strong>Rating</strong>
	</div>
	<div class="col-sm-8">
		<span class="rating">
		    <input type="radio" class="rating-input"
		        id="rating-input-5-5" value="5" readonly="readonly" @if ($supplier->rating == 5) checked @endif>
		    <label for="rating-input-5-5" class="rating-star"></label>
		    <input type="radio" class="rating-input"
		        id="rating-input-5-4"  value="4" readonly="readonly" @if ($supplier->rating == 4) checked @endif>
		    <label for="rating-input-5-4" class="rating-star"></label>
		    <input type="radio" class="rating-input"
		        id="rating-input-5-3" value="3" readonly="readonly" @if ($supplier->rating == 3) checked @endif>
		    <label for="rating-input-5-3" class="rating-star"></label>
		    <input type="radio" class="rating-input"
		        id="rating-input-5-2"  value="2" readonly="readonly" @if ($supplier->rating == 2) checked @endif>
		    <label for="rating-input-5-2" class="rating-star"></label>
		    <input type="radio" class="rating-input"
		        id="rating-input-5-1" value="1" readonly="readonly" @if ($supplier->rating == 1) checked @endif>
		    <label for="rating-input-5-1" class="rating-star"></label>
		</span>
	</div>
</div>
