<?php 
$status = array('OnProcess', 'Approved', 'Canceled');
$sum    = 0;
?>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-responsive table-striped table-condensed">
			<tr>
				<th class="text-center">Payment No</th>
				<th>Date</th>
				<th class="hidden-xs">Staff</th>
				<th>Amount</th>
				<th class="hidden-xs">Status</th>
				<th>Description</th>
				<th class="text-center hidden-xs">Print</th>
			</tr>
			@foreach ($expenses as $expense)
			<?php 
			$sum+=$expense->amount;
			?>
			<tr>
				<td class="text-center">{{$expense->id}}</td>
				<td>{{date('m/d/Y', strtotime($expense->date))}}</td>
				<td class="hidden-xs">{{$expense->user->name}}</td>
				<td>{{number_format($expense->amount, '0', '.', ',')}}</td>
				<td class="hidden-xs">{{$status[$expense->status]}}</td>
				<td>{{$expense->description}}</td>
				<td class="text-center hidden-xs"><button class="btn btn-default print_button" id="{{$expense->id}}"><span class="glyphicon glyphicon-print"></span></button></td>
			</tr>
			@endforeach
			<tr>
				<td></td>
				<td></td>
				<td class="hidden-xs"></td>
				<th>{{number_format($sum, '0', '.', ',')}}</th>
				<td class="hidden-xs"></td>
				<td></td>
				<td class="hidden-xs"></td>
			</tr>
		</table>
	</div>
</div>

<script>
	$(document).ready(function(){
		$('.print_button').click(function(){
			expense_id = $(this).attr('id');
			$.ajax({
					url: '{{Asset('data/payment-form')}}',
					type: 'post',
					data: {expense_id: expense_id},
					success: function (data) {
						$('#print_div').html(data);
						window.print();
					}
				});
		});
	});
</script>