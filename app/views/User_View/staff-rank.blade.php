@extends("theme")

@section('title')
Staff Rank
@endsection

@section('content')
<div class="container" id="content">
	<h1>Staff Rank</h1>
	<br/>
	<?php
	$no = 0;
	?>
	@include('notification')
	<div class="row">
		<div class="col-sm-2">
			<button type="button" class="btn btn-default" data-toggle="modal" href='#new-staffRank'>New Staff Rank</button>
		</div>
	</div>
	<br/>
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-responsive table-striped table-bordered">
				<tr>
					<th class="text-center">No</th>
					<th class="text-center">Staff Name</th>
					<th class="text-center">Low Skill</th>
					<th class="text-center">Basic Skill</th>
					<th class="text-center">High Skill</th>
					<th class="text-center">Expert Skill</th>
					<th class="text-center">Desciption</th>
					<th class="text-center">Action</th>
				</tr>
				@foreach (StaffRank::get() as $staffRank)
				<?php $skillArray = explode(' ', $staffRank->skill_rank) ?>
				<tr>
					<td class="text-center">{{++$no}}</td>
					<td>{{$staffRank->user->name}}</td>
					<td class="text-center">@if (in_array(1, $skillArray)) Yes @else No @endif</td>
					<td class="text-center">@if (in_array(2, $skillArray)) Yes @else No @endif</td>
					<td class="text-center">@if (in_array(3, $skillArray)) Yes @else No @endif</td>
					<td class="text-center">@if (in_array(4, $skillArray)) Yes @else No @endif</td>
					<td>{{$staffRank->description}}</td>
					<td class="text-center">
						<button id="{{$staffRank->id}}" class="btn btn-link delete-button" data-toggle="modal" href='#delete-confirm'>Delete</button>
					</td>
				</tr>
				@endforeach
			</table>
		</div>	
	</div>
</div>

<!-- New Staff Rank modal -->
<div class="modal fade bs-example-modal-lg" id="new-staffRank">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			{{Former::open()->action(Asset('user/staff-rank'))->id('form-staffRank')}}
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">New Staff Rank</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-4">
							{{Former::select('user_id')->class('form-control')->label('Staff Name')->fromQuery(User::where('id', '!=', 16)->get(), 'name', 'id')->placeholder('-- Select a staff name --')}}
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3">
							<div class="checkbox">
								<label>
									<input name="skill_rank[]" type="checkbox" value="1">
									Low skill
								</label>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="checkbox">
								<label>
									<input name="skill_rank[]" type="checkbox" value="2">
									Basic skill
								</label>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="checkbox">
								<label>
									<input name="skill_rank[]" type="checkbox" value="3">
									High skill 
								</label>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="checkbox">
								<label>
									<input name="skill_rank[]" type="checkbox" value="4">
									Master skill
								</label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							{{Former::text('description')->addClass('form-control')}}
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			{{Former::close()}}
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<!-- Delete staff rank modal -->
<div class="modal fade" id="delete-confirm">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="{{Asset('user/delete-staff-rank')}}" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Delete Staff Rank</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<span>Are you sure to delete this Staff Rank??</span>
							<input type="hidden" name="staffRank_id" id="staffRank_id">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Delete Staff Rank</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
	$('#form-staffRank').validate({
		rules:{
			user_id:{
				min:1,
				remote:{
					url:"{{Asset('check/check-staffRank')}}",
					type:"post"
				}
			}
		}
	});

	$('.delete-button').click(function(event) {
		staffRank_id = $(this).attr('id');
		$('#staffRank_id').val(staffRank_id);
	});

</script>

@endsection