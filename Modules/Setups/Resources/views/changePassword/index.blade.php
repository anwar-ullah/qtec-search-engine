@extends('layouts.index')

@section('content')
<div class="row">
	<div class="col-md-6 offset-md-3">
		<div class="card card-info">
			<div class="card-header">
				<h5 style="margin-bottom: 0px !important"><strong>Change Password</strong></h5>
			</div>
			<div class="card-body">
				<form action="{{ route('change-password.store') }}" method="post">
				  @csrf
				  <div class="form-group">
				    <label for="current_password"><strong>Current Password</strong></label>
				    <input type="password" name="current_password" id="current_password" class="form-control" value="{{old('current_password')}}">
				  </div>
				  <div class="form-group">
				    <label for="password"><strong>New Password</strong></label>
				    <input type="password" name="password" id="password" class="form-control" value="{{old('password')}}">
				  </div>
				  <div class="form-group">
				    <label for="password_confirmation"><strong>Confirm New Password</strong></label>
				    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
				  </div>
				  <button class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Change Password</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection