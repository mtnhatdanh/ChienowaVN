<div class="container">
	<span>Chienowa Vietnam</span><br/>
	<span>281 Nguyen Thien Thuat St | Dist 3 | HCMC | Vietnam</span><br/>
</div>
<br/>
<div class="row">
	<div class="col-sm-12 text-center">
		<h3>Transaction</h3>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<table class="table table-responsive table-striped table-condensed">
			<tr>
				<th>Date</th>
				<th>Type</th>
				<th>Name</th>
				<th>Amount</th>
			</tr>
			@foreach (Cache::get('cart') as $transaction)
			<tr>
				<td>{{$transaction->date}}</td>
				<td>@if ($transaction->type=='I') Import @else Export @endif</td>
				<td>{{$transaction->item->getItemName()}}</td>
				<td>{{$transaction->amount}}</td>
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