@extends('layouts.appAdmin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Project name: {{ $project->name }}</h4></div>
                <div class="panel-body">
                    <h4>Tasks:</h4>
                    <table class="table table-striped">
                        <tr>
                            <th>Time</th>
                            <th>EndTime</th>
                            <th>Task</th>
                            <th>Status</th>
                        </tr>
                        @foreach($tasks as $task)
                        <tr>
                            <td>{{ date('d-m-Y H:i',strtotime($task->created_at)) }}</td>
                            <td>{{ date('d-m-Y H:i',$task->date) }}</td>
                            <td><a href="{{ url('task/task/'.$task->id) }}">{{ $task->name }}</a></td>
                            @if($task->status)
                            <td style="color:#070;">Выполнено</td>
                            @else
                            <td style="color:#700;">Не выполнено</td>
                            @endif
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>


            <div class="panel panel-default">
                <div class="panel-heading"><h4>Domens:</h4></div>
                <div class="panel-body">

                    <table class="table table-striped">
                        <tr>
                            <th>Priority</th>
                            <th>Marker</th>
                            <th>Name domen</th>
                            <th>time</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        @foreach($project->domens as $domen)
                        <tr>
                            <td>{{ $domen->pivot->priority }}</td>
                            <td>{{ $domen->marker }}</td>
                            <td><a href="{{ url('domen/domen/'.$domen->id) }}">{{ $domen->name }}</a></td>
                            <td>{{ $domen->updated_at }}</td>
                            <td><a class="btn btn-primary" href="{{ url('domen/priority/'.$domen->id.'/'.$project->id) }}">Edit</a></td>
                            <td><a class="btn btn-danger" href="{{ url('domen/delete/'.$domen->id) }}">Delete</a></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><h4><a href="{{ url('logs/'.$project->id.'/project') }}">Logs:</a></h4></div>
                <div class="panel-body">
                    <div class="row">
                        <div>
                            <ul>
                                @foreach($logs as $log)
                                <li class="log"><?= $log->created_at.' : '.$log->text ?></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection