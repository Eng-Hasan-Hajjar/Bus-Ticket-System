@extends('admin.admin-layout')
@section('admin-dashboard')
<div class="container">
  <div class="row">
    
    <div class="col-md-5 toppad pull-right col-md-offset-3">
      <a href="{{ url('edit-profile-form') }}">Edit Profile</a>
      <br>
      <p class="text-info">Today is: {{ date('d-m-Y', time()) }}</p>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
      <div class="panel panel-info">
        <div class="panel-heading">
          @php 
            $panel_title = Lang::get('admin-dashboard.panel-title');
          @endphp
          <h3 class="panel-title">{{ $panel_title }} {{ auth()->user()->fname }} {{ auth()->user()->lname }}</h3>
        </div>
        <div class="panel-body">
        <div class="row">
          <div class="col-md-3 col-lg-3" align="center">
              <img alt="User Pic" src="/images/pp.png" class="img-circle img-responsive">
          </div>
            <div class="col-md-12 col-lg-12"> 
              <table class="table table-user-information">
                <tbody>
                  
                </tbody>
              </table>
              
              <a href="#" class="btn btn-primary">My Sales Performance</a>
              <a href="#" class="btn btn-primary">Team Sales Performance</a>
            </div>
          </div>
        </div>
        <div class="panel-footer">
          <a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>
          <span class="pull-right">
            <a href="edit.html" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
            <a data-original-title="Remove this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection