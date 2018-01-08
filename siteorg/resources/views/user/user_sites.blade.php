@extends('layouts.app')

@section('breadcrumb')
    <li><a href="/">Home</a></li>
    <li class="active">User sites</li>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Sites<span class="pull-right"><strong>Name:</strong>{{ $user->name }}</span></div>

                    <div class="panel-body">

                        <table class="table">
                            <tr>
                                <td>
                                    Domain
                                </td>
                                <td>
                                    MainUrl
                                </td>
                            </tr>
                            @foreach($sites as $site)
                                <tr>
                                    <td><a href="{{ action('User\UserController@show_user_site_info', [$user->id, $site->id]) }}">{{ $site->domain }}</a></td>
                                    <td>{{ $site->main_url }}</td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $sites->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection