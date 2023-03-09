<form action="{{ route('roles.update',$role->id) }}" method="post" id="create-form" enctype="multipart/form-data">
@csrf
@method('PUT')
  <div class="form-group">
    <label for="name"><strong>Name :</strong></label>
    <input type="text" class="form-control" name="name" id="name" value="{{$role->name}}">
  </div>
  <div class="form-group">
    <label for="sub-roles"><strong>Sub-Roles :</strong></label>
    <br>
    @if(isset($roles[0]))
    @foreach ($roles as $key => $sub_role)
      <div class="icheck-primary d-inline">
        <input type="checkbox" id="sub-role-radio-{{$sub_role->id}}" name="sub_roles[]" value="{{$sub_role->id}}" {{isset(json_decode($role->sub_roles,true)[0]) && in_array($sub_role->id,json_decode($role->sub_roles,true)) ? 'checked' : ''}}>
        <label for="sub-role-radio-{{$sub_role->id}}" class="text-primary">
          {{$sub_role->name}}&nbsp;&nbsp;
        </label>
      </div>
    @endforeach
    @endif
  </div>
  <div class="form-group">
    <label for="desc"><strong>Description :</strong></label>
    <textarea name="desc" class="textarea">{{$role->desc}}</textarea>
  </div>

  @include('layouts.status', ['status' => $role->status])
  
  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update Role</button>
</form>
<script type="text/javascript">
  CKEDITOR.replaceAll( 'textarea' );
</script>