@extends('layouts.index')
@section('content')
<div class="card" style="margin-bottom: 25px;">
    <div class="card-header bg-info text-white" style="cursor: pointer;">
        <h4 class="mb-0">
        	<strong><i class="fa fa-search"></i>&nbsp;Search Engine</strong>
        </h4>
    </div>
    <div class="card-body">
        <form action="{{ url('search-engine/search-engine') }}" method="get" accept-charset="utf-8">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" name="search" value="{{ request()->get('search') }}" placeholder="Search your queries here..." class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <button class="btn btn-success btn-md btn-block"><i class="fa fa-search"></i>&nbsp;Search</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection