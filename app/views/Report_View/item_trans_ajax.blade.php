<div class="container">
	<div class="row">
		<div class="col-sm-6"><strong>{{$item->getItemName()}}</strong></div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-4"><strong>From:</strong> {{date('m/d/Y', strtotime($from_date))}} <strong>to:</strong> {{date('m/d/Y', strtotime($to_day))}} </div>
	</div>
</div>
<br/>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-responsive table-condensed">
			<tr>
				<th class="hidden-xs text-center">Trans No</th>
				<th>Date</th>
				<th>Type</th>
				<th>Amount</th>
				<th>Note</th>
			</tr>

			<?php $trans_no = 0; ?>
			@foreach ($transactions as $transaction)
			<tr>
				<td class="hidden-xs text-center">{{++$trans_no}}</td>
				<td>{{date('m/d/Y', strtotime($transaction->date))}}</td>
				<td>
					@if($transaction->type == 'I') Import
					@else Export
					@endif
				</td>
				<td>{{$transaction->amount}}</td>
				<td>{{$transaction->note}}</td>
			</tr>
			@endforeach

		</table>
	</div>
</div>