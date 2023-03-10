<form action="{{ route('data-models.update', $model->id) }}" method="post" id="crud-form" enctype="multipart/form-data">
@csrf
@method('PUT')
  <div class="form-group">
    <label for="title"><strong>Title :</strong></label>
    <input type="text" class="form-control" name="title" id="title" value="{{ $model->title }}">
  </div>
  <div class="form-group">
    <label for="fine_points"><strong>Fine Points :</strong></label>
    <textarea name="fine_points" class="form-control" style="height: 150px;resize: none;">{{ $model->fine_points }}</textarea>
  </div>
  <div class="form-group">
    <label for="content"><strong>Content :</strong></label>
    <textarea name="content" class="textarea">{{ $model->content }}</textarea>
  </div>

  @include('layouts.status', ['status' => $model->status])

  <button type="submit" class="btn btn-primary crud-button"><i class="fa fa-save"></i>&nbsp; Update Data Model</button>
</form>
<script type="text/javascript">
  CKEDITOR.replaceAll( 'textarea' );
</script>
@include('layouts.crudFormJs')