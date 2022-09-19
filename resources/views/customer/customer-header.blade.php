<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="/" class="navbar-brand">Bus System</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
        	@if ( auth()->check() )
            <li><a href="{{ url('/show-bus-list') }}"><span class="glyphicon glyphicon-calendar"></span> Booking now</a></li>
        	<li><a href="{{ url('/customer-profile') }}"><span class="glyphicon glyphicon-user"></span> {{ auth()->user()->fname }}</a></li>
            <li><a href="{{ url('/logout') }}"><span class="glyphicon glyphicon-log-in"></span> Log out</a></li>
        	@else  
            <li><a href="{{ url('/registration') }}"><span class="glyphicon glyphicon-user"></span> Registration</a></li>
            <li><a href="{{ url('/login-form') }}"><span class="glyphicon glyphicon-log-in"></span> Log in</a></li>
        	@endif
        </ul>
    </div>
</nav>