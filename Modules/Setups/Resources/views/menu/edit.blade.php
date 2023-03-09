<form action="{{ route('menu.update',$menu->id) }}" method="post" id="create-form" enctype="multipart/form-data">
@csrf
@method('PUT')
  <div class="form-group">
    <label for="serial"><strong>Serial :</strong></label>
    <input type="number" class="form-control" name="serial" id="serial" value="{{$menu->serial}}">
  </div>
  <div class="form-group">
    <label for="module_id"><strong>Module :</strong></label>
    <select name="module_id" class="form-control select2bs4">
      @if(isset($modules[0]))
      @foreach ($modules as $key => $module)
        <option value="{{$module->id}}" @if($module->id==$menu->module_id) selected @endif>{{$module->name}}</option>
      @endforeach
      @endif
    </select>
  </div>
  <div class="form-group">
    <label for="name"><strong>Name :</strong></label>
    <input type="text" class="form-control" name="name" id="name" value="{{$menu->name}}">
  </div>
  <div class="form-group">
    <label for="route"><strong>Route :</strong></label>
    <input type="text" class="form-control" name="route" id="route" value={{$menu->route}}>
  </div>
  <div class="form-group">
    <label for="icon"><strong>Icon :</strong></label>
    <input type="text" class="form-control" name="icon" id="icon" value="{{$menu->icon}}">
  </div>
  <div class="form-group">
    <label for="desc"><strong>Description :</strong></label>
    <textarea name="desc" class="textarea">{{$menu->desc}}</textarea>
  </div>
  
  @include('layouts.status', ['status' => $menu->status])

  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update Menu</button>
</form>
<script type="text/javascript">
  CKEDITOR.replaceAll( 'textarea' );
  $('.select2bs4').select2({
    theme: 'bootstrap4'
  });
</script>