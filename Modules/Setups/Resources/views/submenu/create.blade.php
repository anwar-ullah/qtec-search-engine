<form action="{{ route('submenu.store') }}" method="post" id="create-form" enctype="multipart/form-data">
@csrf
  <div class="form-group">
    <label for="serial"><strong>Serial :</strong></label>
    <input type="number" class="form-control" name="serial" id="serial">
  </div>
  <div class="form-group row">
    <div class="col-md-6">
      <label for="create_module_id"><strong>Module :</strong></label>
      <select name="module_id" class="form-control select2bs4" id="create_module_id" onchange="getCreateMenu()">
        @if(isset($modules[0]))
        @foreach ($modules as $key => $module)
          <option value="{{$module->id}}">{{$module->name}}</option>
        @endforeach
        @endif
      </select>
    </div>
    <div class="col-md-6">
      <label for="create_menu_id"><strong>Menu :</strong></label>
      <select name="menu_id" class="form-control select2bs4" id="create_menu_id">
        
      </select>
    </div>
  </div>
  <div class="form-group">
    <label for="name"><strong>Name :</strong></label>
    <input type="text" class="form-control" name="name" id="name">
  </div>
  <div class="form-group">
    <label for="route"><strong>Route :</strong></label>
    <input type="text" class="form-control" name="route" id="route">
  </div>
  <div class="form-group">
    <label for="icon"><strong>Icon :</strong></label>
    <input type="text" class="form-control" name="icon" id="icon">
  </div>
  <div class="form-group">
    <label for="desc"><strong>Description :</strong></label>
    <textarea name="desc" class="textarea"></textarea>
  </div>
  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Save Submenu</button>
</form>
<script type="text/javascript">
  getCreateMenu();
  CKEDITOR.replaceAll( 'textarea' );
  $('.select2bs4').select2({
    theme: 'bootstrap4'
  });
  function getCreateMenu(){
    $.ajax({
      url: "{{url('setups/submenu')}}/"+$('#create_module_id').val()+"/get-menu",
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
    })
    .fail(function() {
      $('#create_menu_id').html('');
    });
  }
</script>