<form action="{{ route('modules.store') }}" method="post" id="create-form" enctype="multipart/form-data">
@csrf
  <div class="form-group">
    <label for="serial"><strong>Serial :</strong></label>
    <input type="number" class="form-control" name="serial" id="serial">
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
  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Save Module</button>
</form>
<script type="text/javascript">
  CKEDITOR.replaceAll( 'textarea' );
</script>