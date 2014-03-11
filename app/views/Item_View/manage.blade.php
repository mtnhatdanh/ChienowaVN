@extends("theme")

@section('title')
Chienowa Vietnam - Manage Items
@endsection

@section('content')
<div class="container" id="content">
	<h1> Items of {{ucfirst($category->name)}}  category</h1>

	<br/>
	
	<table class="table table-responsive table-striped table-bordered">
		<tr>
			<th>No</th> <?php $no = 1; ?>
			<th>Name</th>
			<th>Action</th>
		</tr>
		@foreach($items as $item)
		<tr>
			<td class="text-center"><?php echo $no; $no++; ?></td>
			<td>{{$item->getItemName()}}</td>
			<td class="text-center">
				<button type="button" class="btn btn-link" data-toggle="modal" data-target="#myModal{{$item->id}}">Info</button>
				<a href="{{Asset('item/modify-item/'.$item->id)}}"><button type="button" class="btn btn-link">Modify</button></a>

			</td>

			<!-- Modal -->
			<div class="modal fade" id="myModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        <h4 class="modal-title" id="myModalLabel">Attributes</h4>
			      </div>
			      <div class="modal-body">
			        @foreach ($item->itematt as $itematt)
			        <div class="container">
			        	<div class="col-sm-2">{{Attribute::find($itematt->attribute_id)->name}}:</div>
			        	<div class="col-sm-2">{{$itematt->value}}</div>
			        </div>
			        @endforeach
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      </div>
			    </div>
			  </div>
			</div>

		</tr>
		@endforeach
	</table>
	<div>
		<a href="{{Asset('item/create-item')}}"><button type="button" class="btn btn-primary">Create new Item</button></a>
		<a href="{{Asset('category')}}"><button type="button" class="btn btn-default">Back</button></a>
	</div>
</div>
@endsection