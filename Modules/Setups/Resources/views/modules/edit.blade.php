<form action="{{ route('modules.update',$module->id) }}" method="post" id="create-form" enctype="multipart/form-data">
@csrf
@method('PUT')
  <div class="form-group">
    <label for="serial"><strong>Serial :</strong></label>
    <input type="number" class="form-control" name="serial" id="serial" value="{{$module->serial}}">
  </div>
  <div class="form-group">
    <label for="name"><strong>Name :</strong></label>
    <input type="text" class="form-control" name="name" id="name" value="{{$module->name}}">
  </div>
  <div class="form-group">
    <label for="route"><strong>Route :</strong></label>
    <input type="text" class="form-control" name="route" id="route" value={{$module->route}}>
  </div>
  <div class="form-group">
    <label for="icon"><strong>Icon :</strong></label>
    <input type="text" class="form-control" name="icon" id="icon" value="{{$module->icon}}">
  </div>
  <div class="form-group">
    <label for="desc"><strong>Description :</strong></label>
    <textarea name="desc" class="textarea">{{$module->desc}}</textarea>
  </div>

  @include('layouts.status', ['status' => $module->status])
  
  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update Module</button>
</form>
<script type="text/javascript">
  CKEDITOR.replaceAll( 'textarea' );
</script>