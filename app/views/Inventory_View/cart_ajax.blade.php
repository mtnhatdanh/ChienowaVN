<div class="row">
	<div class="col-sm-12 text-center">
		<h3>Transaction</h3>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-responsive table-striped table-condensed">
			<tr>
				<th class="text-center">Del</th>
				<th>Date</th>
				<th>Type</th>
				<th>Name</th>
				<th>Amount</th>
			</tr>
			@if (Cache::has('cart'))
			@foreach (Cache::get('cart') as $key=>$transaction)
			<tr>
				<td><button id="{{$key}}" class="btn btn-link del_button" type="button"><span class="glyphicon glyphicon-remove"></span></button></td>
				<td>{{$transaction->date}}</td>
				<td>@if ($transaction->type=='I') Import @else Export @endif</td>
				<td>{{$transaction->item->getItemName()}}</td>
				<td>{{$transaction->amount}}</td>
			</tr>
			@endforeach
			@endif
		</table>
	</div>
</div>

<div class="row">
	<div class="col-sm-4">
		<form action="{{Asset('inventory/confirm-transaction')}}" method="post">
			<button class="btn btn-primary" type="submit">Confirm Transaction</button>
		</form>
	</div>
	<div class="col-sm-4">
		<form action="{{Asset('excel-export/new-transaction')}}" method="post">
			<button class="btn btn-default" type="submit">Export to Excel file..</button>
		</form>
	</div>
</div>

<script>
	$('.del_button').click(function(){
		key = $(this).attr('id');
		$.ajax({
				url: '{{Asset('inventory/cart-handle')}}',
				type: 'post',
				data: {key: key},
				success: function () {
					location.reload();
				}
			});
	});
</script>