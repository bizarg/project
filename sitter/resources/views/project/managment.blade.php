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
                    <form class="navbar-form navbar-right" type="get" action="search">
                        <div class="form-group">
                            <input type="text" class="form-control" name="text" placeholder="Search">
                        </div>
                        <button type="submit" class="btn btn-default">Search</button>
                    </form>
            <div class="panel panel-default">
                <div class="panel-heading"><h4>My project<h4>

                </div>
                <div class="panel-body">
                    <div class="row">
                    	<div class="col-md-12">
                    		<table class="table table-striped">
								<tr>
                                    <th>Creator</th>
									<th>Project Name</th>
                                    <th>Description</th>
                                    <th>Domens</th>
                                    <th>Assistants</th>
                                    <th>Edit</th>
									<th>Delete</th>
								</tr>
			                    @foreach($user->projects as $project)
			                    <tr>
                                    <td>{{ $project->user->name }}</td>
			                        <td><a href="{{ url('project/project/'.$project->id) }}">{{ $project->name }}</a></td>
                                    <td>{{ $project->description }}</td>
                                    <td>
                                    @foreach($project->domens as $domen)
                                        {{ $domen->name }}<br> 
                                    @endforeach
                                    </td>
                                    <td>
                                    @foreach($project->assistants as $assistant)
                                        {{ $assistant->name }}<br> 
                                    @endforeach
                                    </td>
                                    <td><a class="btn btn-primary" href="{{ url('project/edit/'.$project->id) }}">Edit</a></td>
			                        <td><a class="btn btn-danger" href="{{ url('project/delete/'.$project->id) }}">Delete</a></td>
	                    		</tr>
	                    		@endforeach
                    		</table>
                    	</div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><h4>My Domens<h4></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">                           
                            <table class="table table-striped">
                                <tr>
                                    <th>Priority</th>
                                    <th>Marker</th>
                                    <th>Name domen</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                @foreach($user->domens as $domen)
                                <tr>
                                    <td>{{ $domen->priority }}</td>
                                    <td>{{ $domen->marker }}</td>
                                    <td><a href="{{ url('domen/domen/'.$domen->id) }}">{{ $domen->name }}</a></td>
                                    <td><a class="btn btn-primary" href="{{ url('domen/edit/'.$domen->id) }}">Edit</a></td>
                                    <td><a class="btn btn-danger" class="link_delete" href="{{ url('domen/delete/'.$domen->id) }}">Delete</a></td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection