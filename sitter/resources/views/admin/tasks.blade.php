@extends('layouts.appAdmin')

@section('content')
<div class="container">
    <div class="row">
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
        <div class="col-md-10 col-md-offset-1">
        <a href="{{ url('admin/create_task') }}" class="btn btn-default active" role="button">New Task</a>
            <div class="panel panel-default">
                <div class="panel-heading">Tasks</div>
                	<div class="panel-body">
	                    <div class="row">
	                        <div class="col-md-12">
	                            <div>
	                                <table class="table table-striped">
	                                    <tr>
	                                        <th>Time</th>
	                                        <th>Task</th>
	                                        <th>Name</th>
	                                        <th>Date</th>
	                                        <th>Status</th>
	                                        <th>Edit</th>
	                                        <th>Delete</th>
	                                    </tr>
	                                    @foreach($tasks as $task)
	                                    <tr>
	                                        <td>{{ date('d-m-Y H:i',strtotime($task->created_at)) }}</td>
	                                        <td><a href="{{ url('task/task/'.$task->id) }}">{{ $task->name }}</a></td>
				                    		<td>{{ $task->taskable->name}}</td>
				                    		<td>{{ date('d-m-Y H:i', $task->date)}}</td>
	                                        @if($task->status)
				                    		<td><a href="{{ url('admin/tasks/status/'.$task->id) }}" class="btn btn-success">Завершено</a></td>
				                    		@else
				                    		<td ><a href="{{ url('admin/tasks/status/'.$task->id) }}" class="btn btn-warning">Не завершено</a></td>
				                    		@endif
				                    		<td>
				                    		<a href="{{ url('admin/edit_task/'.$task->id) }}" class="btn btn-primary active" role="button">Edit</a>
				                    		</td>
				                    		<td><a href="{{ url('admin/delete_task/'.$task->id) }}" class="btn btn-danger active">Delete</a></td>
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
    </div>
</div>
@endsection