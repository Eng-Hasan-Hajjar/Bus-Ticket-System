@php 
use \App\Http\Controllers\CustomerController;
@endphp
@extends('customer.customer-layout')
@section('bus-list')

<div class="container">
  <div class="row">
    
    <div class="col-md-12 toppad pull-right">
      <p class="text-info">Today is: {{ date('d-m-Y', time()) }}</p>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 toppad">
      <div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="panel-title">Bus List</h3>
        </div>
        <div class="panel-body">
        <div class="row">
          @if ( Session::has('msg') )
            <p class="alert alert-info">{{ Session::get('msg') }}</p>
          @endif
          @if ( Session::has('err-msg') )
            <p class="alert alert-danger">{{ Session::get('err-msg') }}</p>
          @endif

          <div class="col-md-12 col-lg-12">
              <table class="table table-user-information">
                <tbody>
                  <tr>
                    <th>Bus ID</th>
                    <th>Bus Name</th>
                    <th>Bus Total Seat</th>
                    <th>Total Available Seat</th>
                    <th>Action</th>
                  </tr>
                  @if ( count($bus_info) > 0 )
                    @foreach ( $bus_info as $data )
                      <tr>
                        <td>{{ $data->id }}</td>
                        <td>{{ $data->bus_name }}</td>
                        <td>{{ $data->total_seat }}</td>
                        <td>{{ CustomerController::getAvailableSeat($data->id) }}</td>
                        <td>
                          <a class="btn btn-primary" href="{{ url('show-bus-seat-detail') . '/' . $data->id }}">Show Seat(s)</a>
                        </td>
                      </tr>
                    @endforeach
                  @endif 
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="panel-footer">
          <a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>
          <span class="pull-right">
            <a href="{{ url('admin/add-bus') }}" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-plus"></i> Add Bus</a>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection