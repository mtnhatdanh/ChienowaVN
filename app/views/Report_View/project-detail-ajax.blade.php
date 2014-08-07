<style>
	td {
		vertical-align: middle!important;
	}
</style>

<?php
$project_id = $project->id;
$status     = array('OnProcess', 'Completed', 'Canceled');
?>
<div class="row">
	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
		<strong>
			Project Name: <br/>
			Status: <br/>
			Note: <br/>
		</strong>
	</div>
	<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
		{{$project->name}}<br/>
		{{$status[$project->status]}}<br/>
		{{$project->note}}
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<br/>
		<strong>Project Items:</strong><br/><br/>
		@foreach ($project->projectDetails as $projectDetail)
		<?php
		$order_product_id = $projectDetail->order_product_id;
		$quotationDetails = DB::table('quotation_details')
							->join('quotation', 'quotation.id', '=', 'quotation_details.quotation_id')
							->select('quotation.date', 'quotation.supplier_id','quotation.note' ,'quotation.project_id', 'quotation_details.id', 'quotation_details.order_product_id', 'quotation_details.price', 'quotation_details.quantity', 'quotation_details.price_usd', 'quotation_details.price_jpy')
							->where('quotation.project_id', '=', $project_id)
							->where('quotation_details.order_product_id', '=', $order_product_id)
							->orderBy('quotation.date', 'desc')
							->get();
		
		?>
		<br/>
		Project Item Name: <span class="label label-info">{{$projectDetail->orderProduct->name}}</span><br/>
		@if($projectDetail->sg_quotation_detail_id)
		<?php
		$sg_quotation_detail = QuotationDetail::find($projectDetail->sg_quotation_detail_id);
		?>
		Suggest supplier: {{$sg_quotation_detail->quotation->supplier->name}}<br/>
		Suggest price: {{number_format($sg_quotation_detail->price, 0, '.', ',')}} VND - {{number_format($sg_quotation_detail->price_usd, 4, '.', ',')}} USD - {{number_format($sg_quotation_detail->price_jpy, 2, '.', ',')}} JPY<br/>
		Suggest note: {{$projectDetail->sg_note}}<br/>
		@endif
		<table class="table table-responsive">
			<thead>
				<tr>
					<th>Suggest</th>
					<th>Supplier</th>
					<th>Date</th>
					<th>Price(VND)</th>
					<th>Price(USD)</th>
					<th>Price(JPY)</th>
					<th>Quantity</th>
					<th class="text-center">Note</th>
				</tr>
			</thead>
			<tbody>
				@foreach($quotationDetails as $quotationDetail)
				<tr @if($projectDetail->sg_quotation_detail_id == $quotationDetail->id) class="success" @endif>
					<td>
						<button type="button" class="btn btn-info suggest-btn" id="{{$quotationDetail->id}}" data-toggle="modal" href='#suggest-modal' @if($projectDetail->sg_quotation_detail_id == $quotationDetail->id) disabled @endif>Suggest</button>
						<input type="hidden" class="projectDetail_id" value="{{$projectDetail->id}}">
					</td>
					<td>
						{{Supplier::find($quotationDetail->supplier_id)->name}}
						<button type="button" id="{{$quotationDetail->supplier_id}}" class="btn btn-link info-button"><span class='glyphicon glyphicon-info-sign'></span></button>
					</td>
					<td>{{date('m/d/Y', strtotime($quotationDetail->date))}}</td>
					<td>{{number_format($quotationDetail->price, 0, '.', ',')}}</td>
					<td>{{number_format($quotationDetail->price_usd, 4, '.', ',')}}</td>
					<td>{{number_format($quotationDetail->price_jpy, 2, '.', ',')}}</td>
					<td>{{$quotationDetail->quantity}}</td>
					<td class="text-center"><button class="btn btn-link note_button" data-container="body" data-toggle="popover" data-placement="left" data-content="{{$quotationDetail->note}}" data-original-title="Note">click to view</button></td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@endforeach
	</div>
</div>
<!-- Supplier infomation modal -->
<div class="modal fade" id="modal-info">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Supplier Infomation</h4>
			</div>
			<div class="modal-body">
				<div id="representative-info"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Suggest button modal -->
<form action="{{asset('report/project-detail-suggest-handle')}}" method="post" id="suggest-project-detail-form">
	<div class="modal fade" id="suggest-modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Suggest modal</h4>
				</div>
				<div class="modal-body">
					<div id="suggest-modal-result"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" data-dismiss="modal" id="suggest-submit-btn">Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</form>

<script>
	$('.note_button').popover();

	// Info button
	$('.info-button').click(function(){
		supplier_id = $(this).attr('id');
		$.ajax({
			url: '{{asset("orders/supplier-info")}}',
			type: 'post',
			data: {supplier_id: supplier_id},
		})
		.done(function(data) {
			console.log("success");
			$('#representative-info').html(data);
			$('#modal-info').modal('show');
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	});

	// Suggesst button handle
	$('.suggest-btn').click(function(){
		sg_quotation_detail_id = $(this).attr("id");
		projectDetail_id = $(this).next(".projectDetail_id").val();
		$.ajax({
			url: '{{asset("report/project-detail-suggest-modal")}}',
			type: 'POST',
			data: {sg_quotation_detail_id: sg_quotation_detail_id, projectDetail_id: projectDetail_id},
		})
		.done(function(data) {
			console.log("success");
			$('#suggest-modal-result').html(data);

		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	});

	// Submit form click
	$('#suggest-submit-btn').click(function(){
		$('#suggest-project-detail-form').submit();
	});

	// Suggest form handle
	var options = {
		target: '#result_div'
	};

	$('#suggest-project-detail-form').validate({
		submitHandler: function(form) {
			$(form).ajaxSubmit(options);
			$("body").removeClass('modal-open');
		}
	});


</script>