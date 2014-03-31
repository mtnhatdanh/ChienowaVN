@if(Cache::has('inspectionDetailTable'))
	<tr>
		<th class="text-center">No Inspected Product</th>
		<th class="text-center">Action</th>
	</tr>
	<?php $no = 0;?>
	@if(count(Cache::get('inspectionDetailTable')))
	@foreach (Cache::get('inspectionDetailTable') as $inspectionDetail)
	<tr>
		<td>Product {{++$no}}</td>
		<td class="text-center">
			<button class="btn btn-link">Del</button>
			<button class="btn btn-link">Modify</button>
		</td>
	</tr>
	@endforeach
	@endif
@endif