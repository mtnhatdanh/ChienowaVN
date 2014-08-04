<style>
	#projectDetail-table td {
		vertical-align: middle;
	}
</style>
<table class="table table-responsive table-bordered" id="projectDetail-table">
	<thead>
		<tr>
			<th>No</th>
			<th>Product name</th>
		</tr>
	</thead>
	<tbody>
		<?php $no = 0;?>
		@foreach ($projectDetails as $projectDetail)
		<tr>
			<td>{{++$no}}</td>
			<td>{{$projectDetail->orderProduct->name}}</td>
		</tr>
		@endforeach
	</tbody>
</table>