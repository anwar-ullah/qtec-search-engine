<form action="{{ route('freelinks.update',$freelink->id) }}" method="post" id="create-form" enctype="multipart/form-data">
@csrf
@method('PUT')
  <div class="form-group">
    <label for="name"><strong>Name :</strong></label>
    <input type="text" class="form-control" name="name" id="name" value="{{$freelink->name}}">
  </div>
  <div class="form-group">
    <label for="route"><strong>Route :</strong></label>
    <input type="text" class="form-control" name="route" id="route" value={{$freelink->route}}>
  </div>
  <div class="form-group">
    <label for="desc"><strong>Description :</strong></label>
    <textarea name="desc" class="textarea">{{$freelink->desc}}</textarea>
  </div>
  
  @include('layouts.status', ['status' => $freelink->status])

  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update Freelink</button>
</form>
<script type="text/javascript">
  CKEDITOR.replaceAll( 'textarea' );
</script>