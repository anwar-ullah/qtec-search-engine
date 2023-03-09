@if(session()->has('success'))
<div class="container" style="margin-top: 25px">
    <div class="row">
	    <div class="col-md-12">
			<div class="alert alert-success alert-dismissible">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
			  {!! session()->get('success') !!}
			</div>
		</div>
	</div>
</div>
@endif

@if(session()->has('danger'))
<div class="container" style="margin-top: 25px">
    <div class="row">
    	<div class="col-md-12">
			<div class="alert alert-danger alert-dismissible">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
			  {!! session()->get('danger') !!}
			</div>
		</div>
	</div>
</div>
@endif

@if($errors->any())
<div class="container" style="margin-top: 25px">
    <div class="row">
    	<div class="col-md-12">
			<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<ul>
					@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
</div>
@endif