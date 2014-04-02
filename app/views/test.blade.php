@extends("theme")

@section('title')
New Daily Report
@endsection

@section('content')
<div class="container">
    <form action="" id="test-form">
        <div class="row">
           <input type="text" name="test1" id="inputTest1" class="form-control">
           <input type="text" name="test2" id="inputTest2" class="form-control">
           <input type="text" name="test3" id="inputTest3" class="form-control">
           <input type="text" name="test4" id="inputTest4" class="form-control">
        </div>
    </form>
</div>

<script>
    $('#test-form').validate();
    $( "#inputTest1" ).rules( "add", {
        min:9.9,
        max:10
    });
    $( "#inputTest2" ).rules( "add", {
        min:100
    });
</script>
@endsection