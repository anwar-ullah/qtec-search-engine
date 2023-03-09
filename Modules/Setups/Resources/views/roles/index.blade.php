@extends('layouts.index')

@section('content')
<div class="card" style="margin-bottom: 25px;">
    <div class="card-header bg-info text-white" style="cursor: pointer;">
        <h4>
        	<strong>Roles</strong>

            @if(isOptionPermitted('setups/roles','create'))
        	   <a class="btn btn-success btn-sm" style="float: right" onclick="Show('New Role','{{ url('setups/roles/create') }}')"><i class=" fa fa-plus"></i>&nbsp;New Role</a>
            @endif
        </h4>
    </div>
    <div class="card-body">
        <span id="datatable-export-file-name" style="display: none;">Roles</span>
        <table class="table table-bordered table-striped datatable">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    @if(auth()->user()->role->is_main == 1)
                    <th>Main Role</th>
                    @endif
                    <th>Sub Roles</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @if(isset($roles[0]))
            @foreach($roles as $key => $role)
                <tr id="tr-{{ $role->id }}">
                    <td style="width: 2%">{{ $key+1 }}</td>
                    <td>{{$role->name}}</td>
                    @if(auth()->user()->role->is_main == 1)
                    <td>{{$role->is_main == 1 ? 'Yes' : 'No'}}</td>
                    @endif
                    <td>
                        @if(isset(json_decode($role->sub_roles,true)[0]))
                        @foreach (json_decode($role->sub_roles,true) as $key => $sub_role_id)
                        @php
                            $sub_role=\Modules\Setups\Entities\Role::find($sub_role_id);
                        @endphp
                            <a class="btn btn-sm btn-info text-white">{{$sub_role ? $sub_role->name : ''}}</a>
                        @endforeach
                        @endif
                    </td>
                    <td>{!! $role->desc !!}</td>
                    <td class="text-center" style="width: 15%">
                        @if($role->status=="1")
                        <a class="btn btn-sm btn-success" onclick="ToggleStatus($(this),'{{$role->getTable()}}','{{$role->id}}')"><i class="fa fa-check text-white"></i></a>
                        @else
                        <a class="btn btn-sm btn-danger" onclick="ToggleStatus($(this),'{{$role->getTable()}}','{{$role->id}}')"><i class="fa fa-ban text-white"></i></a>
                        @endif

                        @php
                            $proceed = false;
                            if(auth()->user()->role->is_main == 1){
                                $proceed = true;
                            }else{
                                $sub_roles = json_decode(auth()->user()->role->sub_roles,true);
                                if(isset($sub_roles[0]) && in_array($role->id, $sub_roles)){
                                    $proceed = true;
                                }
                            }
                        @endphp

                        @if($proceed)
                            @if(isOptionPermitted('setups/roles','edit'))
                                <a class="btn btn-sm btn-info" onclick="Show('Edit Roles','{{ url('setups/roles/'.$role->id.'/edit') }}')"><i class="fa fa-edit text-white"></i></a>
                            @endif

                            @if(isOptionPermitted('setups/roles','delete'))
                                <a class="btn btn-sm btn-danger" onclick="Delete('{{ $role->id }}','{{ url('setups/roles') }}')"><i class="fa fa-trash text-white"></i></a>
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>
@endsection