@extends('theme')

@section('title')
Chienowa Vietnam - Create New Expense
@endsection
@section('content')

<?php
$payment_no = DB::table('information_schema.tables')
			->select('auto_increment')
			->where('table_schema', '=', 'ChienowaVN')
			->where('table_name', '=', 'expenses')
			->first()
			->auto_increment;
?>
<div  id="content" class="container hidden-print">
	<div class="page-header">
		<h1>Create new Expense</h1>
	</div>
	<form action="{{Asset('expense/create-expense')}}" method="post" id="form-register">
		
		<div class="row">
			<div class="form-group col-sm-2">
				<label for="date" class="control-label">Date</label>
				<input type="date" class="form-control" id="date" name="date">
			</div>
			<div class="form-group col-sm-3">
				<label for="staff" class="control-label">Staff</label>
				<select class="form-control" id="user_id" name="user_id">
					<option value="-1">-- Pick a staff name --</option>
					@foreach (User::where('position_id', '!=', 1)->get() as $user)
					<option value="{{$user->id}}">{{$user->name}}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group col-sm-3">
				<label for="currency" class="control-label">Amounts of money</label>
				<div class="input-group">
					<input class="form-control" type="text" id="currency" name="currency" placeholder="Amount of money.." pattern="[0-9]*">
					<span class="input-group-addon">VND</span>
					<input type="hidden" id="amount" name="amount" required>
				</div>
			</div>
			
		</div>
		<div class="row">
			<div class="form-group col-sm-8">
				<label for="description" class="control-label">Description</label>
				<textarea class="form-control" name="description" id="description" rows="4"></textarea>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-sm-2">
				<label>
					<input type="checkbox" id="approved" name="approved" value="1"> Approved
				</label>
			</div>
		</div>
		<br/>

		<div class="row">
			<div class="col-md-2">
				<button type="submit" class="btn btn-primary hidden-xs">Create new Expense</button>
			</div>
			<div class="col-md-1">
				<button type="button" class="btn btn-success hidden-xs" id="print_button">Print</button>
			</div>
			<div class="col-md-1">
				<button type="button" class="btn btn-default">Back</button>
			</div>
		</div>
	</form>
</div>

<div class="container visible-print" id="print_form">
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
		No: {{$payment_no}} - Date: <span id="date_span"></span>
	</div>
	<br/>
	<div class="row">
		<div class="col-xs-2">
			<strong>Receiver:</strong>
		</div>
		<div class="col-xs-10">
			<span id="receiver_span"></span>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-2">
			<strong>For:</strong>
		</div>
		<div class="col-xs-10">
			<span id="description_span"></span>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-2">
			<strong>Amounts:</strong>
		</div>
		<div class="col-xs-10">
			<span id="amounts_span"></span> VND
		</div>
	</div>
	<div class="row">
		<div class="col-xs-2">
			<strong>In words:</strong>
		</div>
		<div class="col-xs-10">
			<span id="inwords_span"></span> VND
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

<script type="text/javascript">
	// Javascript to convert Input Currency, make source input to currency, pass value to target input
	convertInputCurrency('currency', 'amount');

	$('#form-register').validate({
		rules:{
			date:{
				required:true,
			},
			user_id:{
				min:0,
			},
			amount: {
				required:true,
				number: true,
				min:1,
			},
			currency: {
				required:true,
			},
			description: {
				required:true,
			}
		},
		messages:{
			user_id:{
				min:"Please pick a staff name.",
			}
		}
	})

	$('#print_button').click(function(){
		name = $('#user_id').find(":selected").text();
		myDate = new Date($('#date').val());
		myDateString = myDate.getMonth()+1+'/'+myDate.getDate()+'/'+myDate.getFullYear();
		amount_string = toWords($('#amount').val());
		$('#date_span').html(myDateString);
		$('#receiver_span').html(name);
		$('#description_span').html($('#description').val());
		$('#amounts_span').html($('#currency').val());
		$('#inwords_span').html(amount_string);

		window.print();
		return false;
	});

</script>

@endsection