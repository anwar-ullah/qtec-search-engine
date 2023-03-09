@extends('layouts.index')

@section('content')
<script src="{{url('public/lte')}}/plugins/jquery/jquery.min.js"></script>

<div class="card" style="margin-bottom: 25px;">
    <div class="card-header bg-info text-white" style="cursor: pointer;">
        <h4>
        	<strong>Options</strong>

            @if(isOptionPermitted('setups/options','create'))
        	   <a class="btn btn-success btn-sm" style="float: right" onclick="Show('New Option','{{ url('setups/options/create') }}')"><i class=" fa fa-plus"></i>&nbsp;New Option</a>
            @endif
        </h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 offset-md-2">
                <select class="form-control select2bs4" name="menu_id" id="menu_id" onchange="getSubmenu()">
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
            <div class="col-md-3">
                <select class="form-control select2bs4" name="submenu_id" id="submenu_id">
                    
                </select>
            </div>
            <div class="col-md-2">
                <a class="btn btn-primary btn-md btn-block text-white" onclick="searchOptions()"><i class="fa fa-search"></i>&nbsp;Search</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <span id="datatable-export-file-name" style="display: none;">Options</span>
        <table class="table table-bordered table-striped datatable">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>ID</th>
                    <th>Module</th>
                    <th>Menu</th>
                    <th>Submenu</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @if(isset($options[0]))
            @foreach($options as $key => $option)
                <tr id="tr-{{ $option->id }}">
                    <td style="width: 2%">{{ $key+1 }}</td>
                    <td>{{$option->id}}</td>
                    <td>{{$option->menu->module->name}}</td>
                    <td>{{$option->menu->name}}</td>
                    <td>{{$option->submenu ? $option->submenu->name : ''}}</td>
                    <td>{{$option->name}}</td>
                    <td>{!! $option->desc !!}</td>
                    <td class="text-center" style="width: 15%">
                        @include('layouts.crudButtons',[
                            'text' => 'Option',
                            'object' => $option,
                            'link' => 'setups/options'
                        ])
                    </td>
                </tr>
            @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    getSubmenu();
    function getSubmenu(){
        var menu_id = $('#menu_id').val();
        var submenu_id = "{{$submenu_id}}";

        $.ajax({
            url: "{{ url('setups/options') }}/"+menu_id+"/get-submenu",
            type: 'GET',
            dataType: 'json',
            data: {},
        })
        .done(function(response) {
            var submenu = '<option value="0">All Submenu</option>';
            $.each(response, function(index, val) {
                var selected = '';
                if(submenu_id == val.id){
                    selected = 'selected';
                }
                submenu += '<option value="'+(val.id)+'" '+(selected)+'>'+(val.name)+'</option>';
            });

            $('#submenu_id').html(submenu);
        });
    }

    function searchOptions() {
        window.open("{{ url('setups/options') }}/"+$('#menu_id').val()+"&"+$('#submenu_id').val(),"_parent");
    }
</script>
@endsection