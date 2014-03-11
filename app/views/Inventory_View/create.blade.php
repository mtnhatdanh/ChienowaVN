@extends('theme')

@section('title')
Chienowa Vietnam - New Transaction
@endsection
@section('content')

<div class="container">
	<div class="page-header">
		<h1>Create New Transaction</h1>
	</div>
</div>

<style>
	#in_stock_div {
		display: none;
	}
	.autocomplete-suggestions { border: 1px solid #999; background: #FFF; cursor: default; overflow: auto; -webkit-box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); -moz-box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); }
	.autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
	.autocomplete-selected { background: #F0F0F0; }
	.autocomplete-suggestions strong { font-weight: normal; color: #3399FF; }

</style>

@if($notification)
<div class="container alert alert-success">{{$notification}}</div>
@endif



<div class="container">
	<form action="{{Asset('inventory/create')}}" method="post" id="form-register">
		<div class="row">
			<div class="form-group col-sm-3">
				<label for="type">Type</label>
				<select name="type" id="type" class="form-control">
					<option value="I">Import</option>
					<option value="E">Export</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-sm-3">
				<label for="date" class="control-label">Date</label>
				<input type="date" class="form-control" id="date" name="date">
			</div>
			<div class="form-group col-sm-5">
				<label for="item" class="control-label">Item name</label>
				<div class="input-group">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button" data-toggle="modal" data-target="#lookupname" id="lookup_btn"><span class="glyphicon glyphicon-search"></span></button>
					</span>
					<input type="text" class="form-control" id="item" name="item" placeholder="Item name..">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button" data-toggle="modal" data-target="#info_modal" id="info_btn" ><span class="glyphicon glyphicon-info-sign"></span></button>
						<a href="{{Asset('item/create-item')}}"><button class="btn btn-default" type="button"><span class="glyphicon glyphicon-plus"></span></button></a>
					</span>
					<input type="hidden" id="item_id" name="item_id">
				</div>
			</div>
			<div class="form-group col-sm-2">
				<label for="amount" class="control-label">Amount</label>
				<input type="text" class="form-control" id="amount" name="amount" placeholder="Amount..">
			</div>
			<div class="form-group col-sm-2" id="in_stock_div">
				<label for="amount" class="control-label">In Stock</label>
				<input type="text" class="form-control" id="in_stock" placeholder="In Stock.." disabled="disabled">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-sm-12">
				<label for="note" class="control-label">Note</label>
				<textarea class="form-control" name="note" id="note" rows="4"></textarea>
			</div>
		</div>
		<br/>
		<div class="row text-center">
			<button class="btn btn-primary">New Transaction</button>
		</div>
	</form>
	
	<div class="row">
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

<!-- Modal lookup btn -->
<div class="modal fade" id="lookupname" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Lookup Item</h4>
      </div>
      <div class="modal-body">
      	<div class="row">
      		<div class="form-group col-sm-4">
      			<label for="category_name" class="control-label">Category Name</label>
      			<select class="form-control" id="category_name" name="category_name">
      				<option value="0">-- Pick a category --</option>
      				@foreach (Category::get() as $category)
      				<option value="{{$category->id}}">{{ucfirst($category->name)}}</option>
      				@endforeach
      			</select>
      		</div>
      	</div>

      	<div id="lookup_div"></div>

      </div>
      <div class="modal-footer">
      	<button type="button" id="pick_selected_btn" class="btn btn-primary">Pick Selected Item</button>
        <button type="button" id="close_lookup_modal" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>

	//Show or hide In_Stock_Div
	$('#type').change(function(){
		type = $(this).val();
		if(type == 'E') {
			$('#in_stock_div').show();
			getInStockInput();
		}
		else {
			$('#in_stock_div').hide();
			$('#amount').rules("remove", "max");
		}
	});

	// Ajax and add Rule for In Stock Input 
	function getInStockInput(){
		item_id = $('#item_id').val();
		type    = $('#type').val();
		if(item_id !=="" && type == "E")
			$.ajax({
					url: '{{Asset('data/amount-inStock')}}',
					type: 'post',
					data: {item_id: item_id},
					success: function (data) {
						$('#in_stock').val(data);
						$('#amount').rules("remove", "max");
						$('#amount').rules("add",{
							max:data,
							messages:{
								max:"Your amount is excess your In Stock!!"
							}
						});
					}
				});
	}

	// Javascript for autoComplete jquery
	var item_name = [
	@foreach ($itematts as $itematt)
	{ value: '{{$itematt->value}}', data: '{{$itematt->item_id}}' },
	@endforeach
	];

	$('#item').autocomplete({
	    lookup: item_name,
	    onSelect: function (suggestion) {
	        $('#item_id').val(suggestion.data);
	        getInStockInput();
	    }
	});

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

		//ajax for lookup item
		$('#category_name').change(function(){
			category_id = $(this).val();
			if (category_id!==0) {
				$.ajax({
						url: '{{Asset('inventory/pick-category')}}',
						type: 'post',
						data: {category_id: category_id},
						success: function (data) {
							$('#lookup_div').html(data);
						}
					});
			} 
		});
		

		//Lookup_item_select Button Click
		$('#pick_selected_btn').click(function(){
			item_id = $('#lookup_item_select').val();
			name = $('#lookup_item_select').find(":selected").text();
			if(item_id==null) alert('You have not picked an item yet');
			else {
				$('#item_id').val(item_id);
				$('#item').val(name);
				$('#close_lookup_modal').click();
				getInStockInput();
			}
		});

		// validation jquery
		$('#form-register').validate({
			errorLabelContainer: "#validation_errors",
			wrapper: "li",
			rules:{
				date:{
					required:true,
				},
				item:{
					required:true,
					remote:{
						url:"{{Asset('check/check-item-name')}}",
						type:"post"
					}
				},
				item_id:{
					required:true,
					remote:{
						url:"{{Asset('check/check-item-id')}}",
						type:"post"
					}
				},
				amount:{
					required:true,
					number:true,
				}
			},
			messages:{
				date:{
					required:"Date is required.",
				},
				item:{
					remote:"This item does not exist.",
					required:"Item name is required.",
				},
				item_id:{
					required:"Have to select an item.",
					remote:"Have to select an item.",
				},
				amount:{
					required:"Amount is required.",
					number:"Amount must be a number."
				}
			}
		})
	});

</script>


@endsection