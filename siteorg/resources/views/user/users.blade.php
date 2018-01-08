@extends('layouts.app')

@section('breadcrumb')
    <li><a href="/">Home</a></li>
    <li class="active">Users</li>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Users</div>

                    <div class="panel-body">

                        <table class="table">
                            <tr>
                                <td>
                                    Name
                                </td>
                                <td>
                                    Email
                                </td>
                            </tr>
                            @foreach($users as $user)
                                <tr>
                                    <td><a href="{{ action('User\UserController@show_user_sites', [$user->id]) }}">{{ $user->name }}</a></td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $users->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection