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
	div#print_form td {
		text-align: center;
		vertical-align: middle;
		border: 1px solid black!important;
	}
	div#print_form th {
		text-align: center;
		border: 1px solid black!important;
	}
	div#print_form td.signature-td {
		vertical-align: bottom!important;
		height: 100px;
	}
	
	/*div#print_form table.border-print {
		border: 1px solid black!important;
	}
	div#print_form table.border-print th,td {
		border: 1px solid black!important;
	}*/
</style>
<div id="print_form" class="container visible-print">
	<div class="row">
		<div class="col-xs-12 text-center">
			<h3>Final Inspection Sheet</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<table class="table table-responsive table-condensed table-bordered border-print">
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
			<table class="table table-responsive table-condensed table-bordered" id="inspection-print-table">
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
					<!-- Item column -->
					<?php
					if ($j>0 && $inspectionDetailTable[0][$j]->productAtt->order_no != $inspectionDetailTable[0][$j-1]->productAtt->order_no) {
					?>
						<td rowspan="
							<?php
								if ($j<28 && $inspectionDetailTable[0][$j]->productAtt->order_no == $inspectionDetailTable[0][$j+1]->productAtt->order_no) {
									switch ($inspectionDetailTable[0][$j]->productAtt->order_no) {
										case 2:
											echo "2";
											break;
										case 5:
											echo "3";
											break;
										case 7:
											echo "3";
											break;
										case 8:
											echo "3";
											break;
										case 11:
											echo "6";
											break;
										case 12:
											echo "2";
											break;
										case 13:
											echo "2";
											break;

										default:
											echo "1";
											break;
									}
								} else echo "1";
							?>
						">
							{{$inspectionDetailTable[0][$j]->item}}
						</td>
					<?php
					} elseif($j == 0) {
					?>
						<td>{{$inspectionDetailTable[0][$j]->item}}</td>
					<?php } ?>

					
					<!-- Tolerance column -->
					<?php
					if ($j>0 && $j!=2 && $inspectionDetailTable[0][$j]->productAtt->order_no != $inspectionDetailTable[0][$j-1]->productAtt->order_no) {
					?>
						<td rowspan="
							<?php
								if ($j<28 && $inspectionDetailTable[0][$j]->productAtt->order_no == $inspectionDetailTable[0][$j+1]->productAtt->order_no) {
									switch ($inspectionDetailTable[0][$j]->productAtt->order_no) {
										case 5:
											echo "3";
											break;
										case 7:
											echo "3";
											break;
										case 8:
											echo "3";
											break;
										case 11:
											echo "6";
											break;
										case 12:
											echo "2";
											break;
										case 13:
											echo "2";
											break;

										default:
											echo "1";
											break;
									}
								} else echo "1";
							?>
						">
							@if($inspectionDetailTable[0][$j]->productAtt->order_no == 5) φ4 +0.1mm (Note 12)
							@elseif($inspectionDetailTable[0][$j]->productAtt->order_no == 7) φ27 +0.15mm (Note 12)
							@elseif($inspectionDetailTable[0][$j]->productAtt->order_no == 8) φ31.8 -0.15mm (Note 12)
							@elseif($inspectionDetailTable[0][$j]->productAtt->order_no == 11) φ8.9±0.1mm (Note 12)
							@elseif($inspectionDetailTable[0][$j]->productAtt->order_no == 12) No Short Shot appearance (Note 5)
							@elseif($inspectionDetailTable[0][$j]->productAtt->order_no == 13) φ8.3 -0.2mm <br/> φ8.10mm through <br/> φ8.31mm stop
							@else {{$inspectionDetailTable[0][$j]->productAtt->name}}
							@endif
						</td>
					<?php
					} elseif($j==0||$j==2) {
					?>
						<td>{{$inspectionDetailTable[0][$j]->productAtt->name}}</td>
					<?php } ?>

					<!-- Value from input product inspection -->

					<?php
					for ($i=0; $i < $no_columns; $i++) { 
					?>

					<td class="text-left">
						<?php
						switch ($inspectionDetailTable[$i][$j]->product_att_id) {
							case 10:
								echo "MP1: ";
								break;
							case 24:
								echo "MP1: ";
								break;
							case 27:
								echo "MP1: ";
								break;
							case 20:
								echo "MP2: ";
								break;
							case 25:
								echo "MP2: ";
								break;
							case 28:
								echo "MP2: ";
								break;
							case 22:
								echo "MP3: ";
								break;
							case 26:
								echo "MP3: ";
								break;
							case 29:
								echo "MP3: ";
								break;
							case 16:
								echo "L - MP1: ";
								break;
							case 30:
								echo "L - MP2: ";
								break;
							case 31:
								echo "L - MP3: ";
								break;
							case 34:
								echo "R - MP1: ";
								break;
							case 35:
								echo "R - MP2: ";
								break;
							case 36:
								echo "R - MP3: ";
								break;

							default:
								break;
						}
						?>
						{{$inspectionDetailTable[$i][$j]->value}}

					</td>	
					<?php
					}
					?>

					<!-- Inspection tool column -->
					<?php
					if ($j>0 && $inspectionDetailTable[0][$j]->productAtt->order_no != $inspectionDetailTable[0][$j-1]->productAtt->order_no) {
					?>
						<td rowspan="
							<?php
								if ($j<28 && $inspectionDetailTable[0][$j]->productAtt->order_no == $inspectionDetailTable[0][$j+1]->productAtt->order_no) {
									switch ($inspectionDetailTable[0][$j]->productAtt->order_no) {
										case 2:
											echo "2";
											break;
										case 5:
											echo "3";
											break;
										case 7:
											echo "3";
											break;
										case 8:
											echo "3";
											break;
										case 11:
											echo "6";
											break;
										case 12:
											echo "2";
											break;
										case 13:
											echo "2";
											break;

										default:
											echo "1";
											break;
									}
								} else echo "1";
							?>
						">
							{{$inspectionDetailTable[0][$j]->equipment->name}}
						</td>
					<?php
					} elseif($j == 0) {
					?>
						<td>{{$inspectionDetailTable[0][$j]->equipment->name}}</td>
					<?php } ?>


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