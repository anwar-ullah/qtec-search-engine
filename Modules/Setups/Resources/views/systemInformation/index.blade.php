@extends('layouts.index')

@section('content')
<div class="card" style="margin-bottom: 25px;">
    <div class="card-header bg-info text-white" style="cursor: pointer;">
        <h4>
        	<strong>System Information</strong>
        </h4>
    </div>
    <div class="card-body">
        <form action="{{ route('system-information.store') }}" method="post" id="create-form" enctype="multipart/form-data">
        @csrf
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                    <label for="name"><strong>Name :</strong></label>
                    <input type="text" class="form-control" name="name" value="{{$information->name}}" id="name">
                  </div>
                  <div class="form-group">
                    <label for="email"><strong>Email :</strong></label>
                    <input type="text" class="form-control" name="email" value="{{$information->email}}" id="email">
                  </div>
                  <div class="form-group">
                    <label for="phone"><strong>Phone :</strong></label>
                    <input type="text" class="form-control" name="phone" value="{{$information->phone}}" id="phone">
                  </div>
                  <div class="form-group">
                    <label for="mobile"><strong>Mobile :</strong></label>
                    <input type="text" class="form-control" name="mobile" value="{{$information->mobile}}" id="phone">
                  </div>
                  <div class="form-group">
                    <label for="address"><strong>Address :</strong></label>
                    <input type="text" class="form-control" name="address" value="{{$information->address}}" id="phone">
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                    <label for="twitter"><strong>Twitter :</strong></label>
                    <input type="text" class="form-control" name="twitter" value="{{$information->twitter}}" id="twitter">
                  </div>
                  <div class="form-group">
                    <label for="facebook"><strong>Facebook :</strong></label>
                    <input type="text" class="form-control" name="facebook" value="{{$information->facebook}}" id="facebook">
                  </div>
                  <div class="form-group">
                    <label for="instagram"><strong>Instagram :</strong></label>
                    <input type="text" class="form-control" name="instagram" value="{{$information->instagram}}" id="instagram">
                  </div>
                  <div class="form-group">
                    <label for="skype"><strong>Skype :</strong></label>
                    <input type="text" class="form-control" name="skype" value="{{$information->skype}}" id="skype">
                  </div>
                  <div class="form-group">
                    <label for="linked_in"><strong>Linked In :</strong></label>
                    <input type="text" class="form-control" name="linked_in" value="{{$information->linked_in}}" id="linked_in">
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group row">
                    <div class="col-md-7">
                      <label for="logo"><strong>Current Logo :</strong></label>
                      <br>
                      <img src="{{ asset('system-images/logos/'.systemInformation()->logo) }}" class="mt-4 pt-2 img img-fluid">
                    </div>
                    <div class="col-md-5">
                      <label for="icon"><strong>Current Icon :</strong></label>
                      <br>
                      <img src="{{ asset('system-images/icons/'.systemInformation()->icon) }}" class="img img-fluid" style="width: 25%">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="logo_file"><strong>New Logo :</strong></label>
                    <input type="file" class="form-control" name="logo_file" id="logo_file">
                  </div>
                  <div class="form-group">
                    <label for="icon_file"><strong>New Icon :</strong></label>
                    <input type="file" class="form-control" name="icon_file" id="icon_file">
                  </div>
              </div>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i>&nbsp; Update</button>
            </div>
        </form>
    </div>
</div>
@endsection