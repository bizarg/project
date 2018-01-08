@extends('layouts.appAdmin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                @include('errors._sessionBlock')

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
                                    <td><a href="{{ action('Admin\UserController@show', [$user->id]) }}">{{ $user->name }}</a></td>
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