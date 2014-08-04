<style>
	table#project-table td {
		vertical-align: middle;
	}
</style>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-responsive" id="project-table">
			<tr>
				<th>No</th>
				<th>Project Name</th>
				<th class="text-center">Project Detail</th>
				<th class="text-center">Status</th>
				<th class="text-center">Action</th>
			</tr>
			<?php $no = 0;?>
			@foreach ($projects as $project)
			<tr>
				<td>{{++$no}}</td>
				<td>
					<a href="{{asset('orders/quotation-manage/'.$project->id)}}">{{$project->name}}</a>
				</td>
				<td class="text-center">
					<button type="button" class="btn btn-link project-detail-button" data-toggle="modal" href='#project-detail-modal' id="{{$project->id}}">Project Detail</button>
				</td>
				<td class="text-center">
					<?php
					$status = array('on-process', 'completed', 'cancel');
					?>
					{{$status[$project->status]}}
				</td>
				<td class="text-center">
					<a href="{{asset("orders/project-modify/".$project->id)}}"><button type="button" class="btn btn-default modify-button">Modify</button></a>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
</div>

<!-- Project Detail modal -->
<div class="modal fade" id="project-detail-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Project Detail</h4>
			</div>
			<div class="modal-body">
				<div id="project-detail-div"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript">

	// Project Detail button
	$('.project-detail-button').click(function(){
		project_id = $(this).attr('id');
		$.ajax({
			url: '{{asset("orders/project-detail-show")}}',
			type: 'POST',
			data: {project_id: project_id},
		})
		.done(function(data) {
			$('#project-detail-div').html(data);
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	});

</script>