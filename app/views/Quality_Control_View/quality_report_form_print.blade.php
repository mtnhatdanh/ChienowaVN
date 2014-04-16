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
	
	.bold {
		font-weight: bold;
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
			<table class="table table-responsive table-condensed table-bordered border-print">
				<tr>
					<td>NAME</td>
					<td>CHIENOWA VIETNAM CO., LTD</td>
					<td>Sample quantity</td>
					<td>{{$report->sample_qty}}</td>
				</tr>
				<tr>
					<td>Parts No.</td>
					<td>{{$report->part_no}}</td>
					<td>Total quantity</td>
					<td>{{$report->total_qty}}</td>
				</tr>
				<tr>
					<td>Parts name</td>
					<td>{{$report->part_name}}</td>
					<td rowspan="4">Product inspections qty</td>
					<td rowspan="4">{{$report->inspection_qty}}</td>
				</tr>
				<tr>
					<td>Lot No.</td>
					<td>{{$report->lot_no}}</td>
				</tr>
				<tr>
					<td>Delivery date</td>
					<td>{{date('m/d/Y', strtotime($report->delivery_date))}}</td>
				</tr>
			</table>
			<table class="table table-responsive table-condensed table-bordered border-print">
				<tr>
					<td></td>
					<td>NAME</td>
					<td colspan="2">STANDARD - TYPE - COLOR</td>
					<td>JUDGEMENT</td>
					<td>JUDGEMENT</td>
				</tr>
				<tr>
					<td rowspan="2">1</td>
					<td rowspan="2">Plastic stem</td>
					<td>Grade</td>
					<td>Asahi PPS(RG-40JA)</td>
					<td>@if ($report->judgement_grade) OK @else NG @endif</td>
					<td>
						{{Former::checkbox('OK')}}/{{Former::checkbox('NG')}}
					</td>
				</tr>
				<tr>
					<td>Color</td>
					<td>Brown</td>
					<td>@if ($report->judgement_color) OK @else NG @endif</td>
					<td>{{Former::checkbox('OK')}}/{{Former::checkbox('NG')}}</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<table class="table table-responsive table-bordered" id="inspection-print-table">
				<!-- table header -->
				<tr>
					<th rowspan="2">Item</th>
					<th rowspan="2">Standard tolerance</th>
					<th colspan="{{$no_columns}}">Measured value</th>
					<th colspan="2">Purchasing inspection</th>
					
					<th rowspan="2">Inspection tool</th>
				</tr>
				<tr>
					<?php
					for ($i=0; $i < $no_columns; $i++) { 
					?>
					<th width="200px">@if($i==0 || $i==1) cav1 @else cav2 @endif</th>
					<?php
					}
					?>
					<th width="200px">cav1</th>
					<th width="200px">cav2</th>
				</tr>

				<!-- table container -->
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
										case 4:
											echo "2";
											break;
										case 7:
											echo "3";
											break;
										case 9:
											echo "3";
											break;
										case 15:
											echo "6";
											break;
										case 16:
											echo "2";
											break;
										case 17:
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
					if ($j>0 && $j!=4 && $inspectionDetailTable[0][$j]->productAtt->order_no != $inspectionDetailTable[0][$j-1]->productAtt->order_no) {
					?>
						<td rowspan="
							<?php
								if ($j<28 && $inspectionDetailTable[0][$j]->productAtt->order_no == $inspectionDetailTable[0][$j+1]->productAtt->order_no) {
									switch ($inspectionDetailTable[0][$j]->productAtt->order_no) {
										case 7:
											echo "3";
											break;
										case 9:
											echo "3";
											break;
										case 15:
											echo "6";
											break;
										case 16:
											echo "2";
											break;
										case 17:
											echo "2";
											break;

										default:
											echo "1";
											break;
									}
								} else echo "1";
							?>
						">
							@if($inspectionDetailTable[0][$j]->productAtt->order_no == 7) φ4 +0.1mm (Note 12)
							@elseif($inspectionDetailTable[0][$j]->productAtt->order_no == 9) φ27 +0.15mm (Note 12)
							@elseif($inspectionDetailTable[0][$j]->productAtt->order_no == 15) φ8.9±0.1mm (Note 12)
							@elseif($inspectionDetailTable[0][$j]->productAtt->order_no == 16) No Short Shot appearance (Note 5)
							@elseif($inspectionDetailTable[0][$j]->productAtt->order_no == 17) φ8.3 -0.2mm <br/> φ8.10mm through <br/> φ8.31mm stop
							@else {{$inspectionDetailTable[0][$j]->productAtt->name}}
							@endif
						</td>
					<?php
					} elseif($j==0||$j==4) {
					?>
						<td>{{$inspectionDetailTable[0][$j]->productAtt->name}}</td>
					<?php } ?>

					<!-- Value from input product inspection -->

					<?php
					for ($i=0; $i < $no_columns; $i++) { 
					?>

					<td class="text-left @if (!$inspectionDetailTable[$i][$j]->validWattyProduct()) bold @endif">
						<?php
						switch ($inspectionDetailTable[$i][$j]->product_att_id) {
							case 10:
								echo "MP1: ";
								break;
							case 20:
								echo "MP2: ";
								break;
							case 22:
								echo "MP3: ";
								break;
							case 24:
								echo "MP1: ";
								break;
							case 25:
								echo "MP2: ";
								break;
							case 26:
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
							case 32:
								echo "A: ";
								break;
							case 50:
								echo "B: ";
								break;
							case 17:
								echo "pass: ";
								break;
							case 33:
								echo "stop: ";
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
					<!-- Purchasing inspection column -->
					<td></td>
					<td></td>

					<!-- Inspection tool column -->
					<?php
					if ($j>0 && $inspectionDetailTable[0][$j]->productAtt->order_no != $inspectionDetailTable[0][$j-1]->productAtt->order_no) {
					?>
						<td rowspan="
							<?php
								if ($j<28 && $inspectionDetailTable[0][$j]->productAtt->order_no == $inspectionDetailTable[0][$j+1]->productAtt->order_no) {
									switch ($inspectionDetailTable[0][$j]->productAtt->order_no) {
										case 4:
											echo "2";
											break;
										case 7:
											echo "3";
											break;
										case 9:
											echo "3";
											break;
										case 15:
											echo "6";
											break;
										case 16:
											echo "2";
											break;
										case 17:
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