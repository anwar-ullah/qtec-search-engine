@extends('layouts.index')
@section('content')
@include('yajra.css')
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
    
    @if(request()->has('search') && !empty(request()->get('search')))
    @php
        $search = request()->get('search');
    @endphp
    <div class="card-body">
        @if(isset($models[0]))
        @foreach($models as $key => $model)
        <div class="row">
            <div class="col-md-12">
                <h4 class="text-primary">
                    <a style="cursor: pointer" onclick="Show('{{ $model->title }}', '{{ url('search-engine/search-engine/'.$model->id) }}?search={{ $search }}')"><strong>{!! str_replace($search, '<span class="search-text">'.$search.'</span>', $model->title) !!}</strong></a>
                </h4>
                <div>{!! str_replace($search, '<span class="search-text">'.$search.'</span>', $model->fine_points) !!}</div>

                {!! $models->count() > $key+1 ? '<hr>' : '' !!}
            </div>
        </div>
        @endforeach
        @endif

        <div class="row">
            <div class="col-md-12">
                {{ $models->appends(request()->input())->render("pagination::bootstrap-4") }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection