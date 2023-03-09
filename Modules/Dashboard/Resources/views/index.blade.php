@extends('layouts.index')
@section('content')
@include('yajra.css')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header bg-info">
				<h4 class="pb-0 mb-0">
					<strong><i class="fas fa-user-secret"></i>&nbsp;Leads</strong>					
				</h4>
			</div>
			<div class="card-body">
				@include('yajra.datatable')
			</div>
		</div>
	</div>
</div>

<script src="{{ asset('lte') }}/plugins/jquery/jquery.min.js"></script>
@include('yajra.js')
@endsection