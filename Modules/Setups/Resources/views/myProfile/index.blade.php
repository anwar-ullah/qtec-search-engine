@extends('layouts.index')

@section('content')
<script src="{{url('public/lte')}}/plugins/jquery/jquery.min.js"></script>

<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h4 style="margin-bottom: 0px !important"><strong>My Profile</strong></h4>
			</div>
			<div class="card-body">
				<form action="{{ route('my-profile.store') }}" method="post">
				  @csrf
					<div class="form-group row">
						<div class="col-md-12">
							<label for="name"><strong>Name :</strong></label>
			          		<input type="text" class="form-control" name="name" id="name" value="{{auth()->user()->name}}">
						</div>
						{{-- <div class="col-md-4">
							  <label for="gender"><strong>Gender :</strong></label>
					          <select name="gender" id="gender" class="form-control select2bs4">
					            @if(isset(genders()[0]))
					            @foreach (genders() as $key => $gender)
					              <option value="{{$key}}" {{auth()->user()->gender == $key ? 'selected' : ''}}>{{$gender}}</option>
					            @endforeach
					            @endif
					          </select>
						</div> --}}
				    </div>
				  
				  <button class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Update Profile</button>
				</form>
			</div> 
		</div>
	</div>
	<div class="col-md-3">
		<div class="card">
			<div class="card-header">
				<h3><strong>My Image</strong></h3>
			</div>
			<div class="card-body">
				<form action="{{ route('my-image.store') }}" method="post" id="image-form" enctype="multipart/form-data">
				@csrf
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
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="card">
			<div class="card-header">
				<h4 style="margin-bottom: 0px !important"><strong>My Preferences</strong></h4>
			</div>
			<div class="card-body">
				<form action="{{ route('my-preferences.store') }}" method="post">
				  @csrf
				    <div class="form-group">
					  <label for="sound"><strong>Notification Sound :</strong></label>
					  <br>
					  <div class="icheck-primary d-inline">
					    <input type="radio" id="sound-radio-1" name="sound" value="1" {{ ((auth()->user()->sound == 1) ? 'checked' : '') }}>
					    <label for="sound-radio-1" class="text-primary">
					      On&nbsp;&nbsp;
					    </label>
					  </div>
					  <div class="icheck-danger d-inline">
					    <input type="radio" id="sound-radio-0" name="sound" value="0" {{ ((auth()->user()->sound == 0) ? 'checked' : '') }}>
					    <label for="sound-radio-0" class="text-danger">
					      Off&nbsp;&nbsp;
					    </label>
					  </div>
					</div>
				    <button class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Update Preferences</button>
				</form>
			</div> 
		</div>
	</div>
</div>



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