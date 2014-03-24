<?php 
$status = array('OnProcess', 'Approved', 'Canceled');
$sum    = 0;
?>
<div class="container">
	<span>Chienowa Vietnam</span><br/>
	<span>281 Nguyen Thien Thuat St | Dist 3 | HCMC | Vietnam</span><br/>
</div>
<div class="container">
	<span><strong>From day:</strong> {{date('m-d-Y', strtotime($from_day))}} <strong>to day: </strong>{{date('m-d-Y', strtotime($to_day))}}</span><br/>
	<span><strong>Status: <?php if ($status_id<0) echo "All"; else echo($status[$status_id]); ?></strong></span><br/>
	<span><strong>Staff: {{User::find($user_id)->name}}</strong></span>
</div>
<div class="container">
	<h1>Report Transaction</h1>
</div>
<br/>

<div class="row">
	<div class="col-sm-12">
		<table class="table table-responsive table-striped table-condensed">
			<tr>
				<th class="text-center hidden-xs">Payment No</th>
				<th>Date</th>
				<th class="hidden-xs">Staff</th>
				<th class="text-right">Amount</th>
				<th class="hidden-xs">Status</th>
				<th>Description</th>
			</tr>
			@foreach ($expenses as $expense)
			<?php 
			$sum+=$expense->amount;
			?>
			<tr>
				<td class="text-center hidden-xs">{{$expense->id}}</td>
				<td>{{date('m/d/Y', strtotime($expense->date))}}</td>
				<td class="hidden-xs">{{$expense->user->name}}</td>
				<td class="text-right">{{number_format($expense->amount, '0', '.', ',')}}</td>
				<td class="hidden-xs">{{$status[$expense->status]}}</td>
				<td>{{$expense->description}}</td>
			</tr>
			@endforeach
			<tr>
				<td class="hidden-xs"></td>
				<td></td>
				<td class="hidden-xs"></td>
				<th class="text-right"><strong>{{number_format($sum, '0', '.', ',')}}</strong></th>
				<td class="hidden-xs"></td>
				<td></td>
			</tr>
		</table>
	</div>
</div>

<div class="container">
	<span class="text-muted">Copyright &copy; 2014, Chienowa Co., Ltd</span><br/>
	<span class="text-muted">Design by Minh Giang</span><br/>
	<span class="text-muted">Mail to: minh@chienowa.agri-wave.com</span>
</div>