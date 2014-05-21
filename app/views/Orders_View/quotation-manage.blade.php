@extends("theme")

@section('title')
Quotation Manage
@endsection

@section('content')


<div class="container">
	<div class="page-header">
		<h1>Manage Quotation</h1>
	</div>
	@include('notification')
</div>

<div class="container">
	<div class="row">
		<div class="col-sm-3">
			<button class="btn btn-primary" data-toggle="modal" href='#modal-new-quotation'>Create new Quotation</button>
		</div>
	</div>
</div>

@endsection