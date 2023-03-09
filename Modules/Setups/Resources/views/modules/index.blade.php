@extends('layouts.index')

@section('content')
<div class="card" style="margin-bottom: 25px;">
    <div class="card-header bg-info text-white" style="cursor: pointer;">
        <h4>
        	<strong>Modules</strong>
            
            @if(isOptionPermitted('setups/modules','create'))
        	   <a class="btn btn-success btn-sm" style="float: right" onclick="Show('New Module','{{ url('setups/modules/create') }}')"><i class=" fa fa-plus"></i>&nbsp;New Module</a>
            @endif
        </h4>
    </div>
    <div class="card-body">
        <span id="datatable-export-file-name" style="display: none;">Modules</span>
        <table class="table table-bordered table-striped datatable">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Serial</th>
                    <th>Name</th>
                    <th>Route</th>
                    <th>Icon</th>
                    <th>Menu</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @if(isset($modules[0]))
            @foreach($modules as $key => $module)
                <tr id="tr-{{ $module->id }}">
                    <td style="width: 2%">{{ $key+1 }}</td>
                    <td>{{$module->serial}}</td>
                    <td>{{$module->name}}</td>
                    <td>{{$module->route}}</td>
                    <td class="text-center">
                        {{$module->icon}}
                        <br>
                        <i class="{{$module->icon}}"></i>
                    </td>
                    <td>{{$module->menu->count()}}</td>
                    <td>{!! $module->desc !!}</td>
                    <td class="text-center" style="width: 15%">
                        @include('layouts.crudButtons',[
                            'text' => 'Module',
                            'object' => $module,
                            'link' => 'setups/modules'
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