@extends('layouts.index')

@section('content')
<div class="card" style="margin-bottom: 25px;">
    <div class="card-header bg-info text-white" style="cursor: pointer;">
        <h4>
        	<strong>Submenu</strong>

            @if(isOptionPermitted('setups/submenu','create'))
        	   <a class="btn btn-success btn-sm" style="float: right" onclick="Show('New Submenu','{{ url('setups/submenu/create') }}')"><i class=" fa fa-plus"></i>&nbsp;New Submenu</a>
            @endif
        </h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-2 offset-md-5">
                <select class="form-control select2bs4" name="menu_id" id="menu_id" onchange="openLink('{{ url('setups/submenu') }}/'+$('#menu_id').val())">
                    <option value="0">All Menu</option>
                    @if(isset($modules[0]))
                    @foreach ($modules as $key => $module)
                        <optgroup label="{{$module->name}}">
                            @if(isset($module->menu[0]))
                            @foreach ($module->menu as $key => $menu)
                                <option value="{{$menu->id}}" {{$menu_id==$menu->id ? 'selected' : ''}}>&nbsp;&nbsp;&nbsp;&nbsp;{{$menu->name}}</option>
                            @endforeach
                            @endif
                        </optgroup>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>
    <div class="card-body">
        <span id="datatable-export-file-name" style="display: none;">Submenu</span>
        <table class="table table-bordered table-striped datatable">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Module</th>
                    <th>Menu</th>
                    <th>Serial</th>
                    <th>Name</th>
                    <th>Route</th>
                    <th>Icon</th>
                    <th>Options</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @if(isset($submenu[0]))
            @foreach($submenu as $key => $this_submenu)
                <tr id="tr-{{ $this_submenu->id }}">
                    <td style="width: 2%">{{ $key+1 }}</td>
                    <td>{{$this_submenu->menu->module->name}}</td>
                    <td>{{$this_submenu->menu->name}}</td>
                    <td>{{$this_submenu->serial}}</td>
                    <td>{{$this_submenu->name}}</td>
                    <td>{{$this_submenu->route}}</td>
                    <td class="text-center">
                        {{$this_submenu->icon}}
                        <br>
                        <i class="{{$this_submenu->icon}}"></i>
                    </td>
                    <td>
                        <ul>
                            @if(isset($this_submenu->options[0]))
                            @foreach ($this_submenu->options as $key => $option)
                            <li>{{$option->name}}</li>
                            @endforeach
                            @endif
                        </ul>
                    </td>
                    <td>{!! $this_submenu->desc !!}</td>
                    <td class="text-center" style="width: 15%">
                        @include('layouts.crudButtons',[
                            'text' => 'Submenu',
                            'object' => $this_submenu,
                            'link' => 'setups/submenu'
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