<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h3>Quotation suggest</h3>
	</div>
	<br/>
	<?php 
	$quotationDetail = QuotationDetail::find($sg_quotation_detail_id);
	?>
	<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
		<strong>Supplier</strong><br/>
		<strong>Date</strong><br/>
		<strong>Price(VND)</strong><br/>
		<strong>Price(USD)</strong><br/>
		<strong>Price(JPY)</strong><br/>
		<strong>Quantity</strong>
	</div>
	<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
		{{$quotationDetail->quotation->supplier->name}}<br/>
		{{date('m/d/Y', strtotime($quotationDetail->quotation->date))}}<br/>
		{{number_format($quotationDetail->price, 0, '.', ',')}}<br/>
		{{number_format($quotationDetail->price_usd, 4, '.', ',')}}<br/>
		{{number_format($quotationDetail->price_jpy, 2, '.', ',')}}<br/>
		{{$quotationDetail->quantity}}
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<strong>Note: </strong>{{$quotationDetail->quotation->note}}
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<label for="sg_note">Suggest Note</label>
		<textarea class="form-control" rows="3" name="sg_note"></textarea>
	</div>
	<input type="hidden" name="projectDetail_id" value="{{$projectDetail_id}}">
	<input type="hidden" name="sg_quotation_detail_id" value="{{$sg_quotation_detail_id}}">
</div>