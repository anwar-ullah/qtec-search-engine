@extends('layouts.index')

@section('content')
<div class="row">
	<div class="col-md-6 offset-md-3">
		<div class="card">
			<div class="card-header">
				<h5 style="margin-bottom: 0px !important"><strong>Preferences</strong></h5>
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
@endsection