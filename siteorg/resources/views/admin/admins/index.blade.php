@extends('layouts.app_admin')

@section('breadcrumb')
    <li><a href="{{ action('Admin\AdminController@index') }}">Home</a></li>
    <li class="active">Admins</li>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    @include('layouts._block.session_message');

                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-3"><h4>Admins</h4></div>
                            <div class="col-md-2 col-md-offset-6">
                                <a href="{{ route('admins.create') }}" class="btn btn-primary">Create Admin</a>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">

                        <table class="table table-condensed">
                            <tr>
                                <td id="name">Name</td>
                                <td>Email</td>
                                <td>Action</td>
                            </tr>
                            @if(count($users))
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td><a href="{{ route('admins.edit', [$user->id]) }}" class="btn btn-primary">Edit</a>

                                            <a href="#" class="btn btn-danger" onclick="event.preventDefault();document.getElementById('destroy-form{{ $user->id }}').submit();">Delete</a>
                                            <form id="{{ 'destroy-form'.$user->id }}" action="{{ route('admins.destroy', $user->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                            </form>
                                        </td>


                                    </tr>
                                @endforeach
                            @endif
                        </table>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
