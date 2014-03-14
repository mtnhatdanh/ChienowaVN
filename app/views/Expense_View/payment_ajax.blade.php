<?php 
include(app_path().'/myapp/function.php');
?>
<div id="print_form" class="container visible-print">
	<div class="row">
		<div class="col-xs-8">
			<span>Chienowa Co., Ltd</span><br/>
			<span>281 Nguyen Thien Thuat St | Dist 3 | HCMC | Vietnam</span>
		</div>
		<div class="col-xs-4">
			<img src="{{Asset('img/logo.png')}}" alt="Logo" class="img-responsive">
		</div>
	</div>
	<div class="row text-center">
		<h3>PAYMENT</h3>
		No: {{$expense->id}} - Date: <span id="date_span">{{date('m/d/Y', strtotime($expense->date))}}</span>
	</div>
	<br/>
	<div class="row">
		<div class="col-xs-2">
			<strong>Receiver:</strong>
		</div>
		<div class="col-xs-10">
			<span id="receiver_span">{{$expense->user->name}}</span>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-2">
			<strong>For:</strong>
		</div>
		<div class="col-xs-10">
			<span id="description_span">{{$expense->description}}</span>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-2">
			<strong>Amounts:</strong>
		</div>
		<div class="col-xs-10">
			<span id="amounts_span">{{number_format($expense->amount, '0', '.', ',')}}</span> VND
		</div>
	</div>
	<div class="row">
		<div class="col-xs-2">
			<strong>In words:</strong>
		</div>
		<div class="col-xs-10">
			<span id="inwords_span">{{convert_number_to_words($expense->amount)}}</span> VND
		</div>
	</div>
	<div class="row">
		<div class="col-xs-2">
			<strong>Enclosure::</strong>
		</div>
		<div class="col-xs-10">
			... document(s).
		</div>
	</div>
	<br/>
	
	<div class="row">
		<div class="col-xs-4 text-center">
			<strong>RECEIVER</strong>
		</div>
		<div class="col-xs-4 text-center">
			<strong>CASHIER</strong>
		</div>
		<div class="col-xs-4 text-center">
			<strong>HEAD OF COMPANY</strong>
		</div>
	</div>

</div>