@extends("theme")

@section('title')
Test
@endsection

@section('content')
<br/>
<div class="container">
	<div class="row">
		<div class="col-sm-5">
			{{Former::text('autocomplete')->class('form-control')}}
		</div>
	</div>
</div>

<script>
	$('#autocomplete').autocomplete({
	    serviceUrl: '{{asset('test-complete')}}',
	    onSelect: function (suggestion) {
	        alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
	    }
	});
</script>
@endsection