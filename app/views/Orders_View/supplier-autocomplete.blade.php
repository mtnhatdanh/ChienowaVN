{
    "query": "Unit",
    "suggestions": [
    	@foreach (Supplier::get() as $supplier)
        { "value": "{{$supplier->name}}", "data": "{{$supplier->id}}" },
        @endforeach
        { "value": "", "data": "" }
    ]
}