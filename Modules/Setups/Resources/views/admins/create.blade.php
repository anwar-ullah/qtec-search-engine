<form action="{{ route('admins.store') }}" method="post" id="create-form" enctype="multipart/form-data">
@csrf
  
  <div class="form-group row">
    <div class="col-md-6">
      <label for="name"><strong>Name :</strong></label>
      <input type="text" class="form-control" name="name" id="name">
    </div>
    <div class="col-md-6">
      <label for="email"><strong>Email :</strong></label>
      <input type="email" class="form-control" name="email" id="email">
    </div>
  </div>
  <div class="form-group row">
    <div class="col-md-6">
      <label for="password"><strong>Password :</strong></label>
      <input type="password" class="form-control" name="password" id="password">
    </div>
    <div class="col-md-6">
      <label for="password_confirmation"><strong>Confirm Password :</strong></label>
      <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
    </div>
  </div>
  <div class="form-group">
      <label for="role_id"><strong>Role :</strong></label>
      <br>
      @if(isset($roles[0]))
      @foreach ($roles as $key => $role)
        <div class="icheck-success d-inline">
          <input type="radio" id="status-radio-{{$role->id}}" name="role_id" value="{{$role->id}}" {{ (($key == 0) ? 'checked' : '') }}>
          <label for="status-radio-{{$role->id}}" class="text-success">
            {{$role->name}}&nbsp;&nbsp;
          </label>
        </div>
      @endforeach
      @endif
  </div>
  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Save Admin</button>
</form>
<script type="text/javascript">
  CKEDITOR.replaceAll( 'textarea' );
  $('.select2bs4').select2({
    theme: 'bootstrap4'
  });
</script>