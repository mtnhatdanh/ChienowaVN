<div class="row">
	<div class="col-sm-12">
		<table class="table table-responsive table-condensed table-striped">
			<tr>
				<th class="text-center">Pay.No</th>
				<th>Date</th>
				<th>Staff</th>
				<th>Amount (VND)</th>
				<th>Description</th>
				<th>Status</th>
				<td class="text-center">Modify</td>
			</tr>
			<?php 
			$status = array('OnProcess', 'Approved', 'Canceled');
			?>
			@foreach ($expenses as $expense)
			<tr>
				<td class="text-center">{{$expense->id}}</td>
				<td>{{date('m/d/Y', strtotime($expense->date))}}</td>
				<td>{{$expense->user->name}}</td>
				<td>{{number_format($expense->amount, '0', '.', ',')}}</td>
				<td>{{$expense->description}}</td>
				<td>
					<select class="status_select" id="{{$expense->id}}">
						@foreach($status as $key=>$value)
						<option value="{{$key}}" @if($expense->status==$key) selected @endif>{{$value}}</option>
						@endforeach
					</select>
				</td>
				<td class="text-center"><a href="{{Asset('expense/modify')}}/{{$expense->id}}"><button class="btn btn-link">Modify</button></a></td>
			</tr>
			@endforeach
		</table>
	</div>
</div>

<script>
	$(document).ready(function(){
		$('.status_select').change(function(){
			expense_id = $(this).attr('id');
			status     = $(this).val();
			$.ajax({
					url: '{{Asset('expense/update-status')}}',
					type: 'post',
					data: {expense_id: expense_id, status: status},
					success: function (data) {
						// data
					}
				});
		});
	});
</script>