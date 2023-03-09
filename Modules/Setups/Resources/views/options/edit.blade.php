<form action="{{ route('options.update',$option->id) }}" method="post" id="create-form" enctype="multipart/form-data">
@csrf
@method('PUT')
  <div class="form-group row">
    <div class="col-md-4">
      <label for="edit_module_id"><strong>Module :</strong></label>
      <select name="module_id" class="form-control select2bs4" id="edit_module_id" onchange="getMenu()">
        @if(isset($modules[0]))
        @foreach ($modules as $key => $module)
          <option value="{{$module->id}}" @if($option->menu->module_id==$module->id) selected @endif>{{$module->name}}</option>
        @endforeach
        @endif
      </select>
    </div>
    <div class="col-md-4">
      <label for="edit_menu_id"><strong>Menu :</strong></label>
      <select name="menu_id" class="form-control select2bs4" id="edit_menu_id">
        @if(isset($option->menu->module->menu[0]))
        @foreach ($option->menu->module->menu as $key => $menu)
          <option value="{{$menu->id}}" @if($option->menu_id==$menu->id) selected @endif>{{$menu->name}}</option>
        @endforeach
        @endif
      </select>
    </div>
    <div class="col-md-4">
      <label for="edit_submenu_id"><strong>Menu :</strong></label>
      <select name="submenu_id" class="form-control select2bs4" id="edit_submenu_id">
        @if(isset($option->menu->submenu[0]))
        @foreach ($option->menu->submenu as $key => $submenu)
          <option value="{{$submenu->id}}" @if($option->submenu_id==$submenu->id) selected @endif>{{$submenu->name}}</option>
        @endforeach
        @endif
      </select>
    </div>
  </div>
  <div class="form-group">
    <label for="name"><strong>Name :</strong></label>
    <input type="text" class="form-control" name="name" id="name" value="{{$option->name}}">
  </div>
  <div class="form-group">
    <label for="desc"><strong>Description :</strong></label>
    <textarea name="desc" class="textarea">{{$option->desc}}</textarea>
  </div>
  
  @include('layouts.status', ['status' => $option->status])

  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update Option</button>
</form>
<script type="text/javascript">
  CKEDITOR.replaceAll( 'textarea' );
  $('.select2bs4').select2({
    theme: 'bootstrap4'
  });
  
  function getMenu(){
    $.ajax({
      url: "{{url('setups/options')}}/"+$('#edit_module_id').val()+"/get-menu",
      type: 'GET',
      dataType: 'json',
      data: {},
    })
    .done(function(response) {
      var menu='';
      $.each(response, function(index, val) {
        menu+='<option value="'+val.id+'">'+val.name+'</option>';
      });
      $('#edit_menu_id').html(menu);
    })
    .fail(function() {
      $('#edit_menu_id').html('');
    });
  }

  function getSubmenu(){
    $.ajax({
      url: "{{url('setups/options')}}/"+$('#edit_menu_id').val()+"/get-submenu",
      type: 'GET',
      dataType: 'json',
      data: {},
    })
    .done(function(response) {
      var submenu='';
      $.each(response, function(index, val) {
        submenu+='<option value="'+val.id+'">'+val.name+'</option>';
      });
      $('#edit_submenu_id').html(submenu);
    })
    .fail(function() {
      $('#edit_submenu_id').html('');
    });
  }
</script>