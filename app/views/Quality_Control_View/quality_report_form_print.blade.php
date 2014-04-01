<?php
$report_no = DB::table('information_schema.tables')
			->select('auto_increment')
			->where('table_schema', '=', 'ChienowaVN')
			->where('table_name', '=', 'daily_reports')
			->first()
			->auto_increment;

$inspectionDetailTable = Cache::get('inspectionDetailTable');
$no_columns            = count($inspectionDetailTable);
$no_rows               = count($inspectionDetailTable[0]);
?>
<style type="text/css">
	td {
		text-align: center;
		vertical-align: middle;
	}
	th {
		text-align: center;
	}
	td.signature-td {
		vertical-align: bottom!important;
		height: 100px;
	}
</style>
<div id="print_form" class="container visible-print">
	<div class="row">
		<div class="col-xs-12 text-center">
			<h3>Final Inspection Sheet</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<table class="table table-responsive table-condensed table-bordered">
				<tr>
					<td>NAME</td>
					<td>CHIENOWA VIETNAM CO., LTD</td>
					<td>Shot date</td>
					<td>{{date('m/d/Y', strtotime($report->date))}}</td>
				</tr>
				<tr>
					<td>No</td>
					<td>{{$report_no}}</td>
					<td>Product Name</td>
					<td>{{$report->product->name}}</td>
				</tr>
				<tr>
					<td colspan="4">Abnormality report</td>
				</tr>
				<tr>
					<td class="text-left">Equipment</td>
					<td class="text-left">{{$report->equipment}}</td>
					<td class="text-left">Resulted from workers</td>
					<td class="text-left">{{$report->rs_worker}}</td>
				</tr>
				<tr>
					<td class="text-left">Molding machine</td>
					<td class="text-left">{{$report->molding}}</td>
					<td class="text-left">Slight stop</td>
					<td class="text-left">{{$report->slight_stop}}</td>
				</tr>
				<tr>
					<td class="text-left">Metal mold</td>
					<td class="text-left">{{$report->metal_mold}}</td>
					<td class="text-left">Method</td>
					<td class="text-left">{{$report->method}}</td>
				</tr>
				<tr>
					<td class="text-left">Materials</td>
					<td class="text-left">{{$report->materials}}</td>
					<td class="text-left">Other</td>
					<td class="text-left">{{$report->other}}</td>
				</tr>
				<tr>
					<td colspan="2">MATERIAL</td>
					<td>Lot No.</td>
					<td>JUDGEMENT</td>
				</tr>
				<tr>
					<td>Grade</td>
					<td>{{$report->material_grade}}</td>
					<td rowspan="2">{{$report->material_lot_no}}</td>
					<td>@if ($report->judgement_grade) OK @else NG @endif</td>
				</tr>
				<tr>
					<td>Color</td>
					<td>{{$report->material_color}}</td>
					<td>@if ($report->judgement_color) OK @else NG @endif</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<table class="table table-responsive table-condensed table-bordered">
				<tr>
					<th>Item</th>
					<th>Standard tolerance</th>
					<?php
					for ($i=0; $i < $no_columns; $i++) { 
					?>
					<th>Product No: {{$i+1}}</th>
					<?php
					}
					?>
					<th>Inspection tool</th>
				</tr>

				<?php
				for ($j=0; $j < $no_rows; $j++) { 
				?>
				<tr>
					<td>{{$inspectionDetailTable[0][$j]->item}}</td>
					<td>{{$inspectionDetailTable[0][$j]->productAtt->name}}</td>
					<?php
					for ($i=0; $i < $no_columns; $i++) { 
					?>
					<td>{{$inspectionDetailTable[$i][$j]->value}}</td>	
					<?php
					}
					?>
					<td>{{$inspectionDetailTable[0][$j]->equipment->name}}</td>
				</tr>
				<?php
				}
				?>


			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-10">
			<table class="table table-responsive table-condensed table-bordered">
				<tr>
					<th colspan="3">SIGNATURE</th>
				</tr>
				<tr>
					<td>APP'D</td>
					<td>Measurement</td>
					<td>JUDGEMENT</td>
				</tr>
				<tr>
					<td class="signature-td">{{$report->appStaff->name}}</td>
					<td class="signature-td">{{$report->measurementStaff->name}}</td>
					<td><strong>@if ($report->judgement) OK @else NG @endif</strong></td>
				</tr>
			</table>
		</div>
	</div>
</div>