<style type="text/css">
	#order-detail-table td {
		vertical-align: middle;
	}
</style>

<div class="row">
	<div class="col-sm-12 text-center">
		<h3>{{OrderProduct::find($order_product_id)->name}} <small>Product</small></h3>
	</div>
	<div class="col-sm-12">
		{{Former::open()->action(asset('report/quotation-draw-chart'))->id('quotation-draw-chart-form')}}
		<table class="table table-responsive" id="order-detail-table">
			<thead>
				<tr>
					<th>No</th>
					<th class="text-center">Date</th>
					<th>Price(VND)</th>
					<th class="text-center">Quantity</th>
					<th>Supplier</th>
					<th class="text-center">Draw Chart</th>
				</tr>
			</thead>
			<tbody>
				<?php $no = 0;?>
				@foreach ($quotationDetailTable as $quotationDetail)
				<tr>
					<td>{{++$no}}</td>
					<td class="text-center">{{date('m-d-Y', strtotime($quotationDetail->date))}}</td>
					<td>{{number_format($quotationDetail->price, 0, '.', ',')}}</td>
					<td class="text-center">{{$quotationDetail->quantity}}</td>
					<td>
						{{Supplier::find($quotationDetail->supplier_id)->name}}
						<button type="button" id="{{$quotationDetail->supplier_id}}" class="btn btn-link info-button"><span class='glyphicon glyphicon-info-sign'></span></button>
					</td>
					<td class="text-center">
						<label>
							<input type="checkbox" name="quotationDetailArray[]" value="{{$quotationDetail->id}}">
						</label>
					</td>
				</tr>
				@endforeach
				<tr>
					<td colspan="5"></td>
					<td class="text-center">
						<button type="button" class="btn btn-info" id="draw-chart-button">Draw Chart</button>
					</td>
				</tr>
			</tbody>
		</table>
		{{Former::close()}}
	</div>
</div>

<div class="row">
	<div class="col-sm-8 col-sm-offset-2">
		<div id="chart_div"></div>
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

<script type="text/javascript">

	// Prepare for ajax submit
	var options = {
		target: '#chart_div',
		success: showResponse
	};

	function showResponse(responseText, statusText, xhr, $form) {
		google.setOnLoadCallback(drawChart(responseText));
	}

	// draw-chart-button
	$('#draw-chart-button').click(function(event) {
		$('#quotation-draw-chart-form').submit();
	});

	// Draw chart
	$('#quotation-draw-chart-form').validate({
		submitHandler: function(form){
			$(form).ajaxSubmit(options);
			return false;
		}
	});

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
</script>