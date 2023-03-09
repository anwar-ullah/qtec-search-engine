@extends('layouts.index')

@section('content')
<div class="card" style="margin-bottom: 25px;">
    <div class="card-header bg-info text-white" style="cursor: pointer;">
        <h4>
        	<strong>Freelinks</strong>
            
            @if(isOptionPermitted('setups/freelinks','create'))
        	   <a class="btn btn-success btn-sm" style="float: right" onclick="Show('New Freelink','{{ url('setups/freelinks/create') }}')"><i class=" fa fa-plus"></i>&nbsp;New Freelink</a>
            @endif
        </h4>
    </div>
    <div class="card-body">
        <span id="datatable-export-file-name" style="display: none;">Freelinks</span>
        <table class="table table-bordered table-striped datatable">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Route</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @if(isset($freelinks[0]))
            @foreach($freelinks as $key => $link)
                <tr id="tr-{{ $link->id }}">
                    <td style="width: 2%">{{ $key+1 }}</td>
                    <td>{{$link->name}}</td>
                    <td>{{$link->route}}</td>
                    <td>{!! $link->desc !!}</td>
                    <td class="text-center" style="width: 15%">
                        @include('layouts.crudButtons',[
                            'text' => 'Freelink',
                            'object' => $link,
                            'link' => 'setups/freelinks'
                        ])
                    </td>
                </tr>
            @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>
@endsection