@extends('dolil::layouts.index')

@section('content')

<div class="card">
	<div class="card-header"><h3>পাসওয়ার্ড পরিবর্তন করুন</h3></div>
	
	<div class="card-body">
		<form method="POST" action="{{ route('password.update') }}">
			@csrf
			<input type="hidden" name="token" value="{{ $token }}">
			<div class="form-group row">
				<label for="email">আপনার ইমেইল</label>
				<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
				
				@error('email')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>
			
			<div class="form-group row">
				<label for="password">পাসওয়ার্ড লিখুন </label>
				<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
				
				@error('password')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>
			
			<div class="form-group row">
				<label for="password-confirm" >পুনরায় পাসওয়ার্ড লিখুন </label>
				<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
			</div>
			
			<div class="form-group row mb-0">
				<button type="submit" class="btn btn-primary">
					পাসওয়ার্ড পরিবর্তন করুন
				</button>
			</div>
		</form>
	</div>
</div>
@endsection
