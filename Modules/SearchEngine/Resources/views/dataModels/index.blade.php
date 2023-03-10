@extends('layouts.index')
@section('content')
@include('yajra.css')
<div class="card" style="margin-bottom: 25px;">
    <div class="card-header bg-info text-white" style="cursor: pointer;">
        <h4>
        	<strong>Data Models</strong>

            @if(isOptionPermitted('search-engine/data-models','create'))
        	   <a class="btn btn-success btn-sm" style="float: right" onclick="Show('New Data Model','{{ url('search-engine/data-models/create') }}')"><i class=" fa fa-plus"></i>&nbsp;New Data Model</a>
            @endif
        </h4>
    </div>
    <div class="card-body">
        @include('yajra.datatable')
    </div>
</div>
<script src="{{ asset('lte') }}/plugins/jquery/jquery.min.js"></script>
@include('yajra.js')
@endsection