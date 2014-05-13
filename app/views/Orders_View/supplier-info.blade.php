<style>
	table#table-info th {
		border: none;
	}
	table#table-info td {
		border: none;
	}
</style>

<div class="row">
	<div class="col-sm-12">
		<table class="table" id="table-info">
			<tr>
				<th>Representative</th>
				<td>{{$supplier->representative}}</td>
			</tr>
			<tr>
				<th>Moblie</th>
				<td>{{$supplier->mobile}}</td>
			</tr>
			<tr>
				<td colspan="2">
				{{$supplier->note}}
				</td>
			</tr>
		</table>
	</div>
</div>