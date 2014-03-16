@extends('theme')

@section('title')
Chienowa Vietnam - Modify Transaction
@endsection
@section('content')

<div class="container">
	<div class="page-header">
		<h1>Modify Transaction</h1>
	</div>
</div>




<div class="container">
	<form action="{{Asset('inventory/modify/'.$transaction->id)}}" method="post" id="form-register">
		<div class="row">
			<div class="col-sm-2">
				<strong>Transaction ID: </strong>{{$transaction->id}}
			</div>
			<div class="col-sm-2">
				<strong>Type: </strong>@if ($transaction->type=="I") Import @else Export @endif
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="form-group col-sm-3">
				<label for="date" class="control-label">Date</label>
				<input type="date" class="form-control" value="{{$transaction->date}}" readonly="readonly">
			</div>
			<div class="form-group col-sm-5">
				<label for="item" class="control-label">Item name</label>
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Item name.." value="{{$transaction->item->getItemName()}}" readonly>
					<span class="input-group-btn">
						<button class="btn btn-default" type="button" data-toggle="modal" data-target="#info_modal" id="info_btn" ><span class="glyphicon glyphicon-info-sign"></span></button>
					</span>
				</div>
			</div>
			<div class="form-group col-sm-2">
				<label for="amount" class="control-label">Amount</label>
				<input type="text" class="form-control" id="amount" name="amount" placeholder="Amount.." value="{{$transaction->amount}}">
			</div>
			@if ($transaction->type == 'E')
			<div class="form-group col-sm-2" id="in_stock_div">
				<label for="amount" class="control-label">In Stock</label>
				<input type="text" class="form-control" id="in_stock" placeholder="In Stock.." disabled="disabled" value="{{$transaction->item->getInStock()['inStock']+$transaction->amount}}">
			</div>
			@endif
		</div>
		<div class="row">
			<div class="form-group col-sm-12">
				<label for="note" class="control-label">Note</label>
				<textarea class="form-control" name="note" id="note" rows="4">{{$transaction->note}}</textarea>
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="col-sm-2">
				<button class="btn btn-primary btn-block" type="submit">Update Transaction</button>
			</div>
			<div class="col-sm-2">
				<button class="btn btn-default btn-block" type="button" onclick="window.history.back()">Back</button>
			</div>
		</div>
	</form>
	
	<div class="row">
		<br/>
		<ul id="validation_errors"></ul>
	</div>
</div>

<!-- Modal info btn -->
<div class="modal fade" id="info_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Infomation</h4>
      </div>
      <div class="modal-body">
      	<div class="row"></div>
			<div id="item_info">
  		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script>

	// Ajax for info item
	$(document).ready(function(){
		$('#info_btn').click(function(){
			item_id = $('#item_id').val();
			$.ajax({
					url: '{{Asset('inventory/item-info')}}',
					type: 'post',
					data: {item_id: item_id},
					success: function (data) {
						$('#item_info').html(data);
					}
				});
		});
		

		// validation jquery
		$('#form-register').validate({
			errorLabelContainer: "#validation_errors",
			wrapper: "li",
			rules:{
				amount:{
					required:true,
					number:true,
					@if ($transaction->type == 'E')
					max:{{$transaction->item->getInStock()['inStock']+$transaction->amount}},
					@endif
				}
			},
			messages:{
				amount:{
					required:"Amount is required.",
					number:"Amount must be a number.",
					@if ($transaction->type == 'E')
					max: "Your amount is excess your In Stock!!",
					@endif
				}
			}
		})
	});

</script>


@endsection