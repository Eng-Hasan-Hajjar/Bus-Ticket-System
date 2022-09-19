@extends('front-layout')
@section('welcome-content')
    <div class="flex-center position-ref full-height">
        {{-- @if ( Route::has('login') )
            <div class="top-right links">
                @if (Auth::check())
                    <a href="{{ url('/home') }}">Home</a>
                @else
                    <a href="{{ url('/login') }}">Login</a>
                    <a href="{{ url('/register') }}">Register</a>
                @endif
            </div>
        @endif --}}

        <div class="content">
            <div class="title m-b-md">
                @if ( session('Status') ) 
                    <p>{{ session('Status') }}</p>
                @else
                    <p>Welcome to Bus ticket system</p>
                @endif
            </div>
        </div>
    </div>
@endsection