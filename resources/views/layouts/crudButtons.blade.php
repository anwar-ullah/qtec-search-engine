<div class="btn-group">
	@if($object->status=="1")
		<a class="btn btn-sm btn-success" onclick="ToggleStatus($(this),'{{$object->getTable()}}','{{$object->id}}')"><i class="fa fa-check text-white"></i></a>
	@else
		<a class="btn btn-sm btn-danger" onclick="ToggleStatus($(this),'{{$object->getTable()}}','{{$object->id}}')"><i class="fa fa-ban text-white"></i></a>
	@endif
	
	@if(isOptionPermitted($link,'edit'))
		<a class="btn btn-sm btn-info" onclick="Show('Edit {{$text}}','{{ url($link.'/'.$object->id.'/edit') }}')"><i class="fa fa-edit text-white"></i></a>
	@endif
	
	@if(isOptionPermitted($link,'delete'))
		<a class="btn btn-sm btn-danger" onclick="Delete('{{ $object->id }}','{{ url($link) }}')"><i class="fa fa-trash text-white"></i></a>
	@endif
</div>