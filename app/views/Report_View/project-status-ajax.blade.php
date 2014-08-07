<option disabled>-- Pick a project name --</option>
@foreach ($projects as $project)
<option value="{{$project->id}}">{{$project->name}}</option>
@endforeach