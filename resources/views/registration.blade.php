@extends('front-layout')
@section('registration-form')

	<div class="container">
		<div class="row">
			<div class="col-lg-offset-3 col-lg-6">

				@if ( count($errors) > 0 )
					@foreach ( $errors->all() as $error ) 
						<p class="alert alert-danger">{{ $error }}</p>
					@endforeach
				@endif

				<form method="post" action="{{ route('register') }}">
					{{ csrf_field() }}
					<fieldset>
						<legend>Registration Form</legend>
						<div class="form-group">
						  	<label for="exampleInputEmail1">First Name</label>
						  	<input name="fname" value="{{ old('fname') }}" class="form-control" aria-describedby="emailHelp" placeholder="Enter first name" type="text">
						</div>
						<div class="form-group">
						  	<label for="exampleInputEmail1">Last Name</label>
						  	<input name="lname" value="{{ old('lname') }}" class="form-control" aria-describedby="emailHelp" placeholder="Enter last name" type="text">
						</div>
						<div class="form-group">
						  	<label for="exampleInputEmail1">Email address</label>
						  	<input name="email" value="{{ old('email') }}" class="form-control" aria-describedby="emailHelp" placeholder="Enter email" type="email">
						</div>
						<div class="form-group">
						  	<label for="exampleInputPassword1">Password</label>
						  	<input name="password" class="form-control" placeholder="Password" type="password">
						</div>
						<div class="form-group">
						  	<label for="exampleInputPassword1">Confirm Password</label>
						  	<input name="password_confirmation" class="form-control" placeholder="Confirm Password" type="password">
						</div>
						<input type="hidden" name="provider" value="native">
						<input type="hidden" name="provider_id" value="0">
						<button type="reset" class="btn btn-default">Reset</button>
						<button type="submit" class="btn btn-primary">Register</button>
					</fieldset>
				</form>
				<div class="form-group">
					<div class="col-md-6 col-md-offset-4">
						<a href="{{ url('/auth/github') }}" class="btn btn-github"><i class="fa fa-github"></i> Github</a>
						<a href="{{ url('/auth/twitter') }}" class="btn btn-twitter"><i class="fa fa-twitter"></i> Twitter</a>
						<a href="{{ url('/auth/facebook') }}" class="btn btn-facebook"><i class="fa fa-facebook"></i> Facebook</a>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection