@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Logs</div>
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