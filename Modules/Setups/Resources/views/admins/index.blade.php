@extends('layouts.index')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body pb-0">
				<h4>
					<strong>Users</strong>					
					@if(isOptionPermitted('setups/admins','create'))
					<a class="btn btn-success btn-sm text-white" style="float: right" onclick="Show('New User','{{ url('setups/admins/create') }}')"><i class=" fa fa-plus"></i>&nbsp;New User</a>
					@endif
				</h4>
			</div>
			<div class="card-body">
				<span id="datatable-export-file-name" style="display: none;">Users</span>
				<table class="table table-bordered table-striped datatable">
					<thead>
						<tr>
							<th>SL</th>
							<th>Name</th>
							<th>Email</th>
							<th>Username</th>
							<th>User Role</th>
							<th>Image</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@if(isset($admins[0]))
						@foreach($admins as $key => $admin)
						<tr id="tr-{{ $admin->id }}">
							<td style="width: 2%">{{ $key+1 }}</td>
							<td>{{$admin->name}}</td>
							<td>{{$admin->email}}</td>
							<td>{{$admin->username}}</td>
							<td>{{$admin->role ? $admin->role->name : ''}}</td>
							<td class="text-center">
								<img src="{{adminImage($admin)}}" style="height: 50px">
							</td>
							<td class="text-center" style="width: 15%">
								<div class="btn-group">
									@if($admin->status=="1")
									<a class="btn btn-sm btn-success" onclick="ToggleStatus($(this),'{{$admin->getTable()}}','{{$admin->id}}')"><i class="fa fa-check text-white"></i></a>
									@else
									<a class="btn btn-sm btn-danger" onclick="ToggleStatus($(this),'{{$admin->getTable()}}','{{$admin->id}}')"><i class="fa fa-ban text-white"></i></a>
									@endif
									
									@if($admin->id != auth()->user()->id)
									@if(isOptionPermitted('setups/admins','edit'))
									<a class="btn btn-sm btn-info" onclick="Show('Edit User','{{ url('setups/admins/'.$admin->id.'/edit') }}')"><i class="fa fa-edit text-white"></i></a>
									@endif
									
									@if(isOptionPermitted('setups/admins','delete'))
									<a class="btn btn-sm btn-danger" onclick="Delete('{{ $admin->id }}','{{ url('setups/admins') }}')"><i class="fa fa-trash text-white"></i></a>
									@endif
									@endif
								</div>
							</td>
						</tr>
						@endforeach
						@endif
					</tbody>
				</table>
			</div>
		</div>
		<!--/.card-->
	</div>
	<!--/.col-md-12-->
</div>
<!--/.row-->

<script type="text/javascript">
    function searchMe() {
        openLink('{{ url('setups/admins') }}/'+$('#admin').val()+'&'+$('#role_id').val());
	}
</script>
@endsection