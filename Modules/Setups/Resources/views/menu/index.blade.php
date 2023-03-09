@extends('layouts.index')

@section('content')
<div class="card" style="margin-bottom: 25px;">
    <div class="card-header bg-info text-white" style="cursor: pointer;">
        <h4>
        	<strong>Menu</strong>

            @if(isOptionPermitted('setups/menu','create'))
        	   <a class="btn btn-success btn-sm" style="float: right" onclick="Show('New Menu','{{ url('setups/menu/create') }}')"><i class=" fa fa-plus"></i>&nbsp;New Menu</a>
            @endif
        </h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-2 offset-md-5">
                <select class="form-control select2bs4" name="module_id" id="module_id" onchange="openLink('{{ url('setups/menu') }}/'+$('#module_id').val())">
                    <option value="0">All Modules</option>
                    @if(isset($modules[0]))
                    @foreach ($modules as $key => $module)
                        <option value="{{$module->id}}" {{$module_id==$module->id ? 'selected' : ''}}>{{$module->name}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>
    <div class="card-body">
        <span id="datatable-export-file-name" style="display: none;">Menus</span>
        <table class="table table-bordered table-striped datatable">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Module</th>
                    <th>Serial</th>
                    <th>Name</th>
                    <th>Route</th>
                    <th>Icon</th>
                    <th>Submenu</th>
                    <th>Options</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @if(isset($menu[0]))
            @foreach($menu as $key => $this_menu)
                <tr id="tr-{{ $this_menu->id }}">
                    <td style="width: 2%">{{ $key+1 }}</td>
                    <td>{{$this_menu->module->name}}</td>
                    <td>{{$this_menu->serial}}</td>
                    <td>{{$this_menu->name}}</td>
                    <td>{{$this_menu->route}}</td>
                    <td class="text-center">
                        {{$this_menu->icon}}
                        <br>
                        <i class="{{$this_menu->icon}}"></i>
                    </td>
                    <td>{{$this_menu->submenu->count()}}</td>
                    <td>{{$this_menu->options->count()}}</td>
                    <td>{!! $this_menu->desc !!}</td>
                    <td class="text-center" style="width: 15%">
                        @include('layouts.crudButtons',[
                            'text' => 'Menu',
                            'object' => $this_menu,
                            'link' => 'setups/menu'
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