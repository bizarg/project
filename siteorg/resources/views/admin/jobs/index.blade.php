@extends('layouts.app_admin')

@section('breadcrumb')
    <li><a href="{{ action('Admin\AdminController@index') }}">Home</a></li>
    <li class="active">Jobs</li>

@endsection

@section('content')
    <div class="container">
        <div class="row">

            @include('layouts._block.session_message');

            @include('admin.jobs._menu');

            <div class="panel panel-default">
                <div class="panel-heading"><h4>Jobs</h4></div>
                <?php $i = 1;?>
                    <table class="table">
                        <tr>
                            <th>№</th>
                            <th>Queue Name</th>
                            <th>Count</th>
                        </tr>
                        @foreach($jobs as $job)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $job->queue }}</td>
                                <td>{{ $job->queue_count }}</td>
                            </tr>
                        @endforeach
                    </table>
                <div class="panel-body">
                </div>
            </div>
        </div>
    </div>
@endsection
