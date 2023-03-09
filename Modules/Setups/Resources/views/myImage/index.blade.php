@extends('layouts.index')

@section('content')
<script src="{{url('public/lte')}}/plugins/jquery/jquery.min.js"></script>
<form action="{{ route('my-image.store') }}" method="post" id="image-form" enctype="multipart/form-data">
@csrf
	<div class="col-md-4 offset-md-4">
		<div class="form-group" id="image_div">
			<div class="input-group">
			  <div class="custom-file">
			    <input type="file" class="custom-file-input" id="image" name="file">
			    <label class="custom-file-label" for="image">Choose file</label>
			  </div>
			</div>
		</div>
		<div class="form-group" id="preview_div" style="display: none">
			<img id="preview" src="" class="img img-fluid" />
		</div>
		<button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i>&nbsp;Upload</button>
		<a class="btn btn-danger text-white" id="remove_button" style="display: none;cursor: pointer;" onclick="removeImage()"><i class="fa fa-times"></i>&nbsp;Remove</a>
	</div>
</form>
<script type="text/javascript">
	$(document).ready(function() {
		$("#image").change(function() {
		  previewImage(this);
		});
	});

	function previewImage(input) {
	  if (input.files && input.files[0]) {
	    var reader = new FileReader();
	    
	    reader.onload = function(e) {
	      $('#preview').attr('src', e.target.result);
	    }
	    
	    reader.readAsDataURL(input.files[0]);

	    $('#preview_div').show();
	    $('#remove_button').show();
	    $('#image_div').hide();
	  }
	}

	function removeImage(){
		$('#preview').attr('src','#');
		$('#preview_div').hide();
		$('#remove_button').hide();
	    $('#image_div').show();
	    $('#image-form')[0].reset();
	}
</script>
@endsection