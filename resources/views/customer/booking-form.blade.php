@extends('customer.customer-layout')
@section('booking-form')
<div class="container">
  <div class="row">

    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xs-offset-0 col-sm-offset-0 col-md-offset-2 col-lg-offset-2 toppad">
      <div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="panel-title">{{ auth()->user()->fname }} {{ auth()->user()->lname }}</h3>
        </div>
        <div class="panel-body">
        <div class="row">
        
          @if ( Session::has('msg') )
            <p class="alert alert-info">{{ Session::get('msg') }}</p>
          @endif
          
          @if ( Session::has('error') )
            <p class="alert alert-danger">{{ Session::get('error') }}</p>
          @endif

          @if ( count($errors) > 0 )
            @foreach ( $errors->all() as $error )
              <p class="alert alert-danger">{{ $error }}</p>
            @endforeach
          @endif 

          <form method="post" action="{{ route('booking-now') }}">
            {{ csrf_field() }}
            <div class="col-md-12 col-lg-12">
              <table class="table table-user-information">
                <tbody>
                  <tr>
                  <td>Bus Name:</td>
                  <td>{{ $bus_info[0]->bus_name }}</td>
                  </tr>
                  <tr>
                  <td>Seat Number:</td>
                  <td>
                    <input type="text" name="seat_no" value="">
                    <input type="hidden" name="bus_id" value="{{ $bus_info[0]->id }}">
                  </td>
                  </tr>
                  <tr>
                    <td>Booking Cost:</td>
                    <td><input type="text" name="book_cost" id="book_cost" value="10" readonly>$</td>
                  </tr>
                  <tr>
                    <td>Stripe Card Number:</td>
                    <td><input type="text" name="card_no" id="card_no" value="" size="20"></td>
                  </tr>
                  <tr>
                    <td>Stripe CVV Number:</td>
                    <td><input type="text" name="cvvNumber" id="cvvNumber" value="" size="4"></td>
                  </tr>
                  <tr>
                    <td>Stripe Card Expiration:[MM-YYYY]</td>
                    <td><input type="text" name="ccExpiryMonth" id="ccExpiryMonth" value="" size="2">
                      <input type="text" name="ccExpiryYear" id="ccExpiryYear" value="" size="4"></td>
                  </tr>
                  <tr>
                  <tr>
                    <td>Available Seat No:</td>
                    <td>
                      @php 
                        $bus_total_seat = $bus_info[0]->total_seat;
                        for ( $i = 1; $i <= $bus_total_seat; $i++ ) {
                          if ( ! in_array($i, $busy_seats) ) {
                            echo $i . ",";
                          }
                        }
                      @endphp
                    </td>
                  </tr>
                  <td></td>
                  <td><input type="submit" name="submit" value="Booking Now"></td>
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
            <a href="edit.html" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
            <a data-original-title="Remove this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection