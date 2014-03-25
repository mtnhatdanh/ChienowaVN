<style type="text/css">
	td {
		vertical-align: middle!important;
	}
	th {
		text-align: center;
	}
</style>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-responsive table-condensed table-bordered">
			<tr>
				<th>No</th>
				<th>Date</th>
				<th>SumAmount</th>
				<th>OK</th>
				<th>NG</th>
				<th>Equipments Used</th>
				<th>Description</th>
				<th>Action</th>
			</tr>
			<?php 
			$no    = 0; 
			$sumA  = 0;
			$sumOK = 0;
			$sumNG = 0;
			?>
			@foreach ($reports as $report)
			<?php 
			$sumInspection = $report->sumInspection();
			$sumA          += $sumInspection['sum'];
			$sumOK         += $sumInspection['sumOK'];
			$sumNG         += $sumInspection['sumNG'];
			?>
			<tr>
				<td class="text-center">{{++$no}}</td>
				<td class="text-center">{{date('m/d/Y', strtotime($report->date))}}</td>
				<td class="text-right">{{number_format($sumInspection['sum'], 0, '.', ',')}}</td>
				<td class="text-right">{{number_format($sumInspection['sumOK'], 0, '.', ',')}}</td>
				<td class="text-right">{{number_format($sumInspection['sumNG'], 0, '.', ',')}}</td>
				<td class="text-center">{{$report->countEquipment()}}</td>
				<td>{{$report->description}}</td>
				<td class="text-center">
					<a href="{{Asset('quality-control/modify-report/'.$report->id)}}"><button type="button" class="btn btn-link">Modify</button></a>
					<button type="button" class="btn btn-link delete_button" id="{{$report->id}}" data-toggle="modal" data-target="#myModal">Del</button>
				</td>
			</tr>
			@endforeach
			<tr>
				<td colspan="2" class="text-center"><strong>Sumary</strong></td>
				<td class="text-right"><strong>{{number_format($sumA, 0, '.', ',')}}</strong></td>
				<td class="text-right"><strong>{{number_format($sumOK, 0, '.', ',')}}</strong></td>
				<td class="text-right"><strong>{{number_format($sumNG, 0, '.', ',')}}</strong></td>
			</tr>
		</table>
	</div>
</div>

<!-- Modal -->
<form action="{{Asset('quality-control/delete-report')}}" method="post">
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">Delete report</h4>
	      </div>
	      <div class="modal-body">
	        Are you sure delete this report??
	        <input type="hidden" id="report_id" name="report_id">
	      </div>
	      <div class="modal-footer">
	        <div class="row">
	        	<div class="col-sm-5">
	        		<button type="submit" id="del_confirm" class="btn btn-primary btn-block">Delete Report</button>
	        	</div>
	        	<div class="col-sm-3">
	        		<button type="button" class="btn btn-default btn-block" data-dismiss="modal">Close</button>
	        	</div>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
</form>

<script>
	// Javascript for delete button

	$('.delete_button').click(function(){
		report_id = $(this).attr('id');
		$('#report_id').val(report_id);
	});

	
</script>