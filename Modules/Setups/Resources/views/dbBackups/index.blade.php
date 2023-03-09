@extends('layouts.index')

@section('content')
<div class="col-md-8 offset-md-2">
    
<div class="card" style="margin-bottom: 25px;">
    <div class="card-header bg-info text-white" style="cursor: pointer;">
        <h4>
        	<strong>Database Backups</strong>
            
        	<a class="btn btn-success btn-sm" style="float: right" href="{{ url('setups/database-backups/create') }}"><i class=" fa fa-plus"></i>&nbsp;New Database Backups</a>
        </h4>
    </div>
    <div class="card-body">
        <span id="datatable-export-file-name" style="display: none;">Database Backups</span>
        <table class="table table-bordered table-striped datatable">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Database Backup File (.SQL)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @if(isset($files[0]))
            @foreach($files as $key => $file)
            @php
                $name = $file->getFilename();
                $size = formatBytes($file->getSize());
            @endphp
                <tr id="tr-{{ $key }}">
                    <td style="width: 2%">{{ $key+1 }}</td>
                    <td>
                        <h5>{{$name}}</h5>
                        <h6>{{$size}}</h6>
                    </td>
                    <td class="text-center" style="width: 15%">
                        <a class="btn btn-sm btn-primary text-white" href="{{ url('setups/database-backups/'.$name) }}">Download</a>
                        <a class="btn btn-sm btn-danger text-white" href="{{ url('setups/database-backups/'.$name.'/edit') }}">Delete</a>
                    </td>
                </tr>
            @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>
</div>

@endsection