@extends('layouts.app_admin')

@section('breadcrumb')
    <li><a href="{{ action('Admin\AdminController@index') }}">Home</a></li>
    <li><a href="{{ route('users.index') }}">Users</a></li>
    <li class="active">{{ $user->name }}</li>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    @include('layouts._block.session_message');

                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-3">
                                <h4>Name: {{ $user->name }}</h4></div>
                            <div class="col-md-2 col-md-offset-6">
                                <a href="{{ route('users.edit', [$user->id]) }}" class="btn btn-primary">Edit</a>
                                <a href="#" class="btn btn-danger"
                                   onclick="event.preventDefault();document.getElementById('destroy-form').submit();">Delete</a>
                                <form id="destroy-form" action="{{ route('users.destroy', [$user->id]) }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>
                            </div>
                        </div>
                    </div>

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
                                <td><a href="{{ route('sites.show', [$site->id]) }}">{{ $site->domain }}</a></td>
                                <td>{{ $site->main_url }}</td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $sites->links() }}
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-2"><h4>Contacts</h4></div>
                            <div class="col-md-2 col-md-offset-7">
                                <a class="btn btn-default" href="{{ action('Admin\ContactController@create', [$user->id]) }}">Create contact</a>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <td>Type</td>
                            <td>Contact</td>
                            <td>Action</td>
                        </tr>
                        @foreach($user->contacts as $contact)
                            <tr>
                                <td>{{ $contact->type }}</td>
                                <td>{{ $contact->contact }}</td>
                                <td>
                                    <span class="pull-right">
                                        @if($contact->notify)
                                            <a href="{{ action('Admin\AdminController@notify', [$contact->id]) }}" class="btn btn-success" data-notify="notify" data-id="{{ $contact->id }}">Notify</a>
                                        @else
                                            <a href="{{ action('Admin\AdminController@notify', [$contact->id]) }}" class="btn btn-danger" data-notify="notify" data-id="{{ $contact->id }}">Notify</a>
                                        @endif

                                        <a href="{{ action('Admin\ContactController@edit', [$contact->id, $user->id]) }}" class="btn btn-primary">Edit</a>

                                        <a href="{{ action('Admin\ContactController@delete', [$contact->id, $user->id]) }}" class="btn btn-danger">Delete</a>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading"><h4>Referals</h4></div>
                    <table class="table table-condensed">
                        <tr>
                            <td>Name</td>
                            <td>Email</td>
                        </tr>
                        @if(count($referals))
                            @foreach($referals as $user)
                                <tr>
                                    <td><a href="{{ route('users.show', [$user->id]) }}">{{ $user->name }}</a></td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="text-center"><td colspan="2">Null</td></tr>
                        @endif
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>

        $(document).ready(function(){

            $("[data-notify='notify']").on('click', function(e){
                e.preventDefault();
                var that = $(this);
                $.ajax({
                    url: that.attr('href'),
                    type: 'get',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data:  that.attr('data-id'),
                    success: function(json){
                        if(json == 1){
                            that.attr('class', 'btn btn-danger');
                        } else {
                            that.attr('class', 'btn btn-success');
                        }
                    },
                });
            });


        });

    </script>
@endsection