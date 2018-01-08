@extends('layouts.appAdmin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
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
            <div class="panel panel-default">
                <div class="panel-heading">Admin panel</div>
                <div class="panel-body">
                    <table class="table table-striped">
                    	<tr>
                    		<th>Name</th>
                    		<th>Email</th>
                    		<th>Status</th>
                    	</tr>
                    	@foreach($users as $user)
                    	<tr>
                    		<td>{{ $user->name }}</td>
                    		<td>{{ $user->email }}</td>
                    		@if($user->status)
                    		<td><a href="{{ url('admin/users/status/'.$user->id) }}" class="btn btn-success">Одобрен</a></td>
                    		@else
                    		<td ><a href="{{ url('admin/users/status/'.$user->id) }}" class="btn btn-warning">Не одобрен</a></td>
                    		@endif
                    	</tr>
                    	@endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection