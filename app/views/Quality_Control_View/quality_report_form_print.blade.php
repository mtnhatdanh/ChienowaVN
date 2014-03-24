<?php
$inspections = Cache::get('inspections');
$sum         = 0;
$sumOK       = 0;
$sumNG       = 0;
foreach ($inspections as $key => $inspection) {
	$sum += $inspection->amount;
	if ($inspection->quality == 1) {
		$sumOK += $inspection->amount;
	} else $sumNG += $inspection->amount;
}
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
		<h3>Quality Control Report</h3>
		<span>Date: {{date('m/d/Y', strtotime($date))}}</span><br/>
		<span>Description: {{$description}}</span>
	</div>
	<br/>
	<div class="row">
		<div class="col-xs-4">
			<strong>Total products checked: </strong><span>{{$sum}}</span>
		</div>
		<div class="col-xs-4">
			<strong>Total products OK: </strong><span>{{$sumOK}}</span>
		</div>
		<div class="col-xs-4">
			<strong>Total products NG: </strong><span>{{$sumNG}}</span>
		</div>
	</div>
	<br/>

	<div class="row">
		<div class="col-xs-12">
			<table class="table table-responsive table-condensed table-bordered">
				<tr>
					<th class="text-center">No</th>
					<th>Staff</th>
					<th>Amount</th>
					<th class="text-center">Quality</th>
					<th>Description</th>
				</tr>

				<?php 
				$no  = 0;
				?>
				@foreach ($inspections as $key=>$inspection)
				<tr>
					<td class="text-center">{{++$no}}</td>
					<td>{{$inspection->user->name}}</td>
					<td>{{$inspection->amount}}</td>
					<td class="text-center">@if ($inspection->quality) OK @else NG @endif</td>
					<td>{{$inspection->description}}</td>
				</tr>
				@endforeach
				<tr>
					<td class="text-center" colspan="2"><strong>Sumary</strong></td>
					<td><strong>{{$sum}}</strong></td>
					<td colspan="2"></td>
				</tr>
				
				
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<strong>Staff Signature</strong>
		</div>
	</div>

</div>