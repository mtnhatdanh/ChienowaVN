<div class="container">
	<div class="col-sm-6"><strong>{{$item->getItemName()}}</strong></div>
</div>
<div class="container">
	<div class="col-sm-4"><strong>From:</strong> {{$from_date}} <strong>to:</strong> {{$to_day}}</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-responsive">
			<tr>
				<th>Trans No</th>
				<th>Date</th>
				<th>Type</th>
				<th>Amount</th>
				<th>Note</th>
			</tr>
			<tr>
				<?php $trans_no = 0; ?>
				@foreach ($transactions as $transaction)
				<td>{{++$trans_no}}</td>
				<td>{{$transaction->date}}</td>
				<td>
					@if($transaction->type == 'I') Import
					@else Export
					@endif
				</td>
				<td>{{$transaction->amount}}</td>
				<td>{{$transaction->note}}</td>
				@endforeach
			</tr>
		</table>
	</div>
</div>