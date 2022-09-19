@extends('customer.customer-layout')
@section('customer-welcome-content')
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                @if(auth()->check())
                    {{ 'Welcome' }} {{ auth()->user()->fname }}
                @endif
            </div>
        </div>
    </div>
@endsection