@extends('front-layout')
@section('login-form')

	<div class="container">
		<div class="row">
			<div class="col-lg-offset-3 col-lg-6">

				@if ( Session::has('msg') ) 
				<p class="alert alert-success">{{ Session::get('msg') }}</p>
				@endif

				@if ( count($errors) > 0 )
					@foreach ( $errors->all() as $error ) 
						<p class="alert alert-danger">{{ $error }}</p>
					@endforeach
				@endif

				<form method="post" action="{{ route('login') }}">
					{{ csrf_field() }}
					<fieldset>
						<legend>Login Form</legend>
						<div class="form-group">
						  	<label for="exampleInputEmail1">Email address</label>
						  	<input name="email" value="{{ old('email') }}" class="form-control" aria-describedby="emailHelp" placeholder="Enter email" type="email">
						</div>
						<div class="form-group">
						  	<label for="exampleInputPassword1">Password</label>
						  	<input name="password" class="form-control" placeholder="Password" type="password">
						</div>
						<button type="reset" class="btn btn-default">Reset</button>
						<button type="submit" class="btn btn-primary">Login</button>
					</fieldset>
				</form>

				<div class="form-group">
					<div class="col-md-6 col-md-offset-4">
						<a href="{{ url('/auth/github') }}" class="btn btn-github"><i class="fa fa-github"></i> Github</a>
						<a href="{{ url('/auth/twitter') }}" class="btn btn-twitter"><i class="fa fa-twitter"></i> Twitter</a>
						<a href="{{ url('/login/facebook') }}" class="btn btn-facebook"><i class="fa fa-facebook"></i> Facebook</a>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection