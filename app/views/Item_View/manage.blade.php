@extends("theme")

@section('title')
Chienowa Vietnam - Manage Items
@endsection

@section('content')
<div class="container" id="content">
	<h1> Items of {{ucfirst($category->name)}}  category</h1>

	<br/>
	
	<table class="table table-responsive table-striped table-bordered table-condensed">
		<tr>
			<th>No</th> <?php $no = 1; ?>
			<th>Name</th>
			<th class="text-center">Action</th>
		</tr>
		@foreach($items as $item)
		<tr>
			<td class="text-center"><?php echo $no; $no++; ?></td>
			<td>{{$item->getItemName()}}</td>
			<td class="text-center">
				<button type="button" class="btn btn-link info_button" id="{{$item->id}}" data-toggle="modal" data-target="#myModal">Info</button>
				<a href="{{Asset('item/modify-item/'.$item->id)}}"><button type="button" class="btn btn-link hidden-xs">Modify</button></a>

			</td>

		</tr>
		@endforeach
	</table>
	<div>
		<a href="{{Asset('item/create-item')}}"><button type="button" class="btn btn-primary hidden-xs">Create new Item</button></a>
		<a href="{{Asset('category')}}"><button type="button" class="btn btn-default">Back</button></a>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Attributes</h4>
      </div>
      <div class="modal-body">
        	<div id="info_div"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('.info_button').click(function(){
			item_id = $(this).attr('id');
			$.ajax({
					url: '{{Asset('data/item-info')}}',
					type: 'post',
					data: {item_id: item_id},
					success: function (data) {
						$('#info_div').html(data);
					}
				});
		});
	});
</script>

@endsection