<div id="print_form" class="container visible-print">
	<div class="row">
		<div class="col-xs-8">
			<span>Chienowa Co., Ltd</span><br/>
			<span>281 Nguyen Thien Thuat St | Dist 3 | HCMC | Vietnam</span>
		</div>
		<div class="col-xs-4">
			<img src="{{Asset('img/logo.png')}}" alt="Logo" class="img-responsive">
		</div>
	</div>
	<div class="row text-center">
		<h3>Equipments Calibration</h3>
		<span>Date: {{date('m/d/Y', strtotime($date))}}</span><br/>
		<span>Description: {{$description}}</span>
	</div>
	<br/>
	<div class="row">
		<div class="col-xs-12">
			<table class="table table-responsive table-condensed table-bordered">
				<tr>
					<th class="text-center">Equipment No</th>
					<th>Equipment Name</th>
					<th>Before Inspection</th>
					<th>After Inspection</th>
				</tr>
				@foreach (Cache::get('calibrations') as $calibration)
				<tr>
					<td class="text-center">{{$calibration->equipment->id}}</td>
					<td>{{$calibration->equipment->name}}</td>
					<td>{{$calibration->before_inspection}}</td>
					<td>{{$calibration->after_inspection}}</td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<strong>Staff Signature</strong>
		</div>
	</div>

</div>