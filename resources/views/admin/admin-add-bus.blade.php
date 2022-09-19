@extends('admin.admin-layout')
@section('admin-add-bus')
<div class="container">
  <div class="row">

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
      <div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="panel-title">Add new bus</h3>
        </div>
        <div class="panel-body">
        <div class="row">
        
          @if ( Session::has('msg') )
            <p class="alert alert-info">{{ Session::get('msg') }}</p>
          @endif

          @if ( count($errors) > 0 ) 
            @foreach ( $errors->all() as $error ) 
              <p class="alert alert-danger">{{ $error }}</p>
            @endforeach
          @endif

          <form method="post" action="{{ route('admin-add-bus') }}">
            {{ csrf_field() }}
            <div class="col-md-12 col-lg-12"> 
              <table class="table table-user-information">
                <tbody>
                  <tr>
                  <td>Bus Name:</td>
                  <td><input type="text" name="bus_name" value=""></td>
                  </tr>
                  <tr>
                  <td>Total Seat:</td>
                  <td><input type="text" name="total_seat" value=""></td>
                  </tr>
                  <tr>
                  <td></td>
                  <td><input type="submit" name="submit" value="Add"></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </form>
          
          </div>
        </div>
        <div class="panel-footer">
          <a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>
          <span class="pull-right">
            <a data-original-title="Remove this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection