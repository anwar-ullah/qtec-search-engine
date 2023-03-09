<form action="{{ route('roles.store') }}" method="post" id="create-form" enctype="multipart/form-data">
@csrf
  <div class="form-group">
    <label for="name"><strong>Name :</strong></label>
    <input type="text" class="form-control" name="name" id="name">
  </div>
  <div class="form-group">
    <label for="sub-roles"><strong>Sub-Roles :</strong></label>
    <br>
    @if(isset($roles[0]))
    @foreach ($roles as $key => $role)
      <div class="icheck-primary d-inline">
        <input type="checkbox" id="sub-role-radio-{{$role->id}}" name="sub_roles[]" value="{{$role->id}}">
        <label for="sub-role-radio-{{$role->id}}" class="text-primary">
          {{$role->name}}&nbsp;&nbsp;
        </label>
      </div>
    @endforeach
    @endif
  </div>
  <div class="form-group">
    <label for="desc"><strong>Description :</strong></label>
    <textarea name="desc" class="textarea"></textarea>
  </div>
  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Save Role</button>
</form>
<script type="text/javascript">
  CKEDITOR.replaceAll( 'textarea' );
</script>