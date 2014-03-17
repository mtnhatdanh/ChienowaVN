<div class="container">
	<span>Chienowa Vietnam</span><br/>
	<span>281 Nguyen Thien Thuat St | Dist 3 | HCMC | Vietnam</span><br/>
</div>
<div class="container">
	<span><strong>From day:</strong> {{date('m-d-Y', strtotime($from_day))}} <strong>to day: </strong>{{date('m-d-Y', strtotime($to_day))}}</span><br/>
	<span>Type: @if ($transaction->type == 'I') Import @elseif ($transaction->type == "E") Export @else All @endif</span><br/>
</div>
<div class="container">
	<h1>Report Transaction</h1>
</div>
<br/>

<div class="row">
	<div class="col-sm-12">
		<table class="table table-responsive table-condensed table-striped">
			<tr>
				<th class="hidden-xs">No</th>
				<th>Date</th>
				<th>Item</th>
				<th>Type</th>
				<th>Amount</th>
				<th class="hidden-xs">Unit</th>
				<th>Note</th>
			</tr>
			<?php $no = 0;?>
			@foreach ($transactions as $transaction)
			<tr>
				<td class="hidden-xs">{{++$no}}</td>
				<td>{{date('m-d-Y', strtotime($transaction->date))}}</td>
				<td>{{$transaction->item->getItemName()}}</td>
				<td>@if ($transaction->type == 'I') Import @else Export @endif</td>
				<td>
					{{$transaction->amount}}
				</td>
				<td class="hidden-xs">{{$transaction->item->getItemUnit()}}</td>
				<td>{{$transaction->note}}</td>
			</tr>
			@endforeach
		</table>
	</div>
</div>

<div class="container">
	<span class="text-muted">Copyright &copy; 2014, Chienowa Co., Ltd</span><br/>
	<span class="text-muted">Design by Minh Giang</span><br/>
	<span class="text-muted">Mail to: minh@chienowa.agri-wave.com</span>
</div>