@extends('layouts.index')
@section('content')
@include('yajra.css')
<div class="card" style="margin-bottom: 25px;">
    <div class="card-header bg-info text-white" style="cursor: pointer;">
        <h4 class="mb-0">
        	<strong>Statistics</strong>
        </h4>
    </div>
    <div class="card-body">
        <form action="{{ route('statistics.store') }}" method="post" id="statistics-form" accept-charset="utf-8">
        @csrf
            <div class="row">
                <div class="col-md-4">
                    <label for="keywords"><strong>Keywords</strong></label>
                    <select name="keywords[]" id="keywords" class="form-control select2bs4" multiple>
                      @if(is_array($keywords) && count($keywords) > 0)
                      @foreach ($keywords as $keyword => $count)
                        <option value="{{ $keyword }}">{{ $keyword }} ({{ $count }} times found)</option>
                      @endforeach
                      @endif
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="users"><strong>Users</strong></label>
                    <select name="users[]" id="users" class="form-control select2bs4" multiple>
                      @if(isset($users[0]))
                      @foreach ($users as $key => $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                      @endforeach
                      @endif
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="daterange"><strong>Daterange</strong></label>
                    <input type="text" name="daterange" value="" placeholder="Choose Your daterange..." class="form-control">
                </div>
                <div class="col-md-2 pt-4">
                    <button type="submit" class="mt-2 btn btn-success btn-md btn-block statistics-button"><i class="fa fa-search"></i>&nbsp;Search</button>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body statistics">
        
    </div>
</div>
<script src="{{ asset('lte') }}/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var form = $('#statistics-form');
        var button = form.find('.statistics-button');
        var buttonContent = button.html();
        searchModels(form, button, buttonContent);

        form.submit(function(event) {
            event.preventDefault();
            searchModels(form, button, buttonContent);
        });
    });

    function searchModels(form, button, buttonContent, page = 0){
        button.prop('disabled', true).html('<i class="fas fa-spinner"></i>&nbsp;Please wait...');
        $.ajax({
            url: form.attr('action')+(page > 0 ? '?page='+page : ''),
            type: form.attr('method'),
            data: form.serializeArray(),
        })
        .done(function(response) {
            $('.statistics').html(response);
            button.prop('disabled', false).html(buttonContent);
        })
        .fail(function(response) {
            var errors = '<ul class="pl-3">';
            $.each(response.responseJSON.errors, function(index, val) {
                errors += '<li>'+val[0]+'</li>';
            });
            errors += '</ul>';
            notify(errors, 'danger');

            button.prop('disabled', false).html(buttonContent);
        });
    }
</script>
@endsection