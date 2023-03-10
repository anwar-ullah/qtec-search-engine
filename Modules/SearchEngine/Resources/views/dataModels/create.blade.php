<form action="{{ route('data-models.store') }}" method="post" id="crud-form" enctype="multipart/form-data">
@csrf
  <div class="form-group">
    <label for="title"><strong>Title :</strong></label>
    <input type="text" class="form-control" name="title" id="title">
  </div>
  <div class="form-group">
    <label for="fine_points"><strong>Fine Points :</strong></label>
    <textarea name="fine_points" class="form-control" style="height: 150px;resize: none;"></textarea>
  </div>
  <div class="form-group">
    <label for="content"><strong>Content :</strong></label>
    <textarea name="content" class="textarea"></textarea>
  </div>
  <button type="submit" class="btn btn-primary crud-button"><i class="fa fa-save"></i>&nbsp; Save Data Model</button>
</form>
<script type="text/javascript">
  CKEDITOR.replaceAll( 'textarea' );
</script>
@include('layouts.crudFormJs')