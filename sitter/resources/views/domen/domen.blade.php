@extends('layouts.appAdmin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-4">Name: {{ $domen->name }}</div>
                        <div class="col-md-4">Marker: {{ $domen->marker }}</div>
                        <div class="col-md-4">Priority: {{ $domen->priority }}</div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <h4>Tasks:</h4>
                                <table class="table table-striped">
                                    <tr>
                                        <th>Time</th>
                                        <th>End</th>
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
                                {{ $tasks->links() }}
                            </div>  
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading"><a href="{{ url('logs/'.$domen->id.'/domen') }}">Logs</a></div>
                <div class="panel-body">
                    <div class="row">
                        <div>
                            <ul class="log">
                                @foreach($logs as $log)
                                <li><?= $log->created_at.' : '.$log->text ?></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
                    
            <div class="panel panel-default">
                <div class="panel-heading"><a href="{{ url('comments/'.$domen->id.'/domen') }}">Comments</a></div>
                <div class="panel-body">
                    <div>
                    @foreach($comments as $comment)
                        <div style="border:1px solid silver;padding-left: 20px;margin-bottom: 3px;">
                            <div class="author">
                            <span style="font-size:18px;color:#f00;">{{ $comment->user_name }}</span><span style="font-size:10px;"> {{ $comment->created_at }}</span></div>
                            <div class="comment" style="">{{ $comment->text }}</div>
                        </div>
                    @endforeach
                    </div>
                    <div style="margin-top: 30px;padding-top: 10px;">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('comment/'.$domen->id) }}">
                        {{ csrf_field() }}
                            <input type="hidden" name="object" value="domen">
                             <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                                <label for="text" class="col-md-4 control-label">Comment</label>
                                <div class="col-md-6">
                                    <textarea id="text" type="textarea" class="form-control" name="text" rows='3'></textarea>                               
                                    @if ($errors->has('text'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('text') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Add Comment
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection