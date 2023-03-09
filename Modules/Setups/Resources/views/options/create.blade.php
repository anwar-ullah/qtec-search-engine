<form action="{{ route('options.store') }}" method="post" id="create-form" enctype="multipart/form-data">
@csrf
  <div class="form-group row">
    <div class="col-md-4">
      <label for="create_module_id"><strong>Module :</strong></label>
      <select name="module_id" class="form-control select2bs4" id="create_module_id" onchange="getMenu()">
        @if(isset($modules[0]))
        @foreach ($modules as $key => $module)
          <option value="{{$module->id}}">{{$module->name}}</option>
        @endforeach
        @endif
      </select>
    </div>
    <div class="col-md-4">
      <label for="create_menu_id"><strong>Menu :</strong></label>
      <select name="menu_id" class="form-control select2bs4" id="create_menu_id" onchange="getSubmenu()">
        
      </select>
    </div>
    <div class="col-md-4">
      <label for="create_submenu_id"><strong>SubMmenu :</strong></label>
      <select name="submenu_id" class="form-control select2bs4" id="create_submenu_id">
        
      </select>
    </div>
  </div>
  <div class="form-group">
    <label for="name"><strong>Name :</strong></label>
    <input type="text" class="form-control" name="name" id="name">
  </div>
  <div class="form-group">
    <label for="desc"><strong>Description :</strong></label>
    <textarea name="desc" class="textarea"></textarea>
  </div>
  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Save Option</button>
</form>
<script type="text/javascript">
  getMenu();
  CKEDITOR.replaceAll( 'textarea' );
  $('.select2bs4').select2({
    theme: 'bootstrap4'
  });

  function getMenu(){
    console.log('getMenu');
    $.ajax({
      url: "{{url('setups/options')}}/"+$('#create_module_id').val()+"/get-menu",
      type: 'GET',
      dataType: 'json',
      data: {},
    })
    .done(function(response) {
      var menu='';
      $.each(response, function(index, val) {
        menu+='<option value="'+val.id+'">'+val.name+'</option>';
      });
      $('#create_menu_id').html(menu);
      getSubmenu();
    })
    .fail(function() {
      $('#create_menu_id').html('');
      getSubmenu();
    });
  }

  function getSubmenu(){
    console.log('getSubMenu');
    $.ajax({
      url: "{{url('setups/options')}}/"+$('#create_menu_id').val()+"/get-submenu",
      type: 'GET',
      dataType: 'json',
      data: {},
    })
    .done(function(response) {
      var submenu='';
      $.each(response, function(index, val) {
        submenu+='<option value="'+val.id+'">'+val.name+'</option>';
      });
      $('#create_submenu_id').html(submenu);
    })
    .fail(function() {
      $('#create_submenu_id').html('');
    });
  }
</script>