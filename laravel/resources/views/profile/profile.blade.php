@extends('layouts.appAdmin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            	@if(Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}          
                </div>
                @endif
                @if(Session::has('successfully'))
                <div class="alert alert-success">
                    {{ Session::get('successfully') }}          
                </div>
                @endif
                <div class="panel-heading">Personal settings</div>
                <div class="panel-body">
					<ul class="nav navbar-nav navbar-left">
						<li><a href="{{ url('/profile/user') }}">Profile</a></li>
						<li><a href="{{ url('/profile/account') }}">Account</a></li>
					</ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
