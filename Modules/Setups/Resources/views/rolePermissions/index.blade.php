@extends('layouts.index')

@section('content')
@if(isset(json_decode(auth()->user()->role->sub_roles,true)[0]))

<script src="{{url('public/lte')}}/plugins/jquery/jquery.min.js"></script>
<div class="card" style="margin-bottom: 25px;">
    <div class="card-header bg-info text-white" style="cursor: pointer;">
        <h4>
        	<strong>Role Permissions</strong>
        </h4>
    </div>
    <div class="card-body">
        <form action="{{ route('role-permissions.store') }}" method="post" id="create-form" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="role_id"><strong>Choose Role :</strong></label>
            <select name="role_id" class="form-control select2bs4" id="role_id" onchange="getPermissions()">
              @if(isset($roles[0]))
              @foreach ($roles as $key => $role)
                <option value="{{$role->id}}">{{$role->name}}</option>
              @endforeach
              @endif
            </select>
        </div>

        <div class="form-group row" id="permission-view">
            
        </div>

        <button type="submit" class="btn btn-primary" id="permission-button" style="display: none;"><i class="fa fa-save"></i>&nbsp; Update Role Permissions</button>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        getPermissions();
    });
    
    function getPermissions(){
        $('#permission-view').html('<div class="col-md-4 offset-md-4"><h3><strong>Please wait...</strong></h3></div>');
        $('#permission-button').hide();
        $.ajax({
            url: "{{ url('setups/role-permissions') }}/"+$('#role_id').val(),
            type: 'GET',
            data: {},
        })
        .done(function(response) {
            $('#permission-view').html(response);
            $('#permission-button').show();
            modifyCheckboxes();
        })
        .fail(function(){
            $('#permission-view').html('');
            $('#permission-button').hide();
        });
    }

    function modifyCheckboxes() {
        $.each($('.module'), function(index, val) {
            if($(this).is(':checked')){
               $('.module-menu-'+($(this).val())).removeAttr('disabled'); 
               $('.module-submenu-'+($(this).val())).removeAttr('disabled'); 
               $('.module-option-'+($(this).val())).removeAttr('disabled');

               $.each($('.module-menu-'+($(this).val())), function(index, val) {
                    if(!$(this).is(':checked')){
                        $('.menu-submenu-'+($(this).val())).attr('disabled',true); 
                        $('.menu-option-'+($(this).val())).attr('disabled',true); 
                    }

                    $.each($('.menu-submenu-'+($(this).val())), function(index, val) {
                        if(!$(this).is(':checked')){
                            $('.submenu-option-'+($(this).val())).attr('disabled',true); 
                        }
                    });    
               }); 
            }else{
               $('.module-menu-'+($(this).val())).attr('disabled',true); 
               $('.module-submenu-'+($(this).val())).attr('disabled',true); 
               $('.module-option-'+($(this).val())).attr('disabled',true); 
            }
        });
    }
</script>

@endif
@endsection