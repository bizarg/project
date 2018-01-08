@extends('layouts.app_admin')

@section('breadcrumb')
    <li><a href="{{ action('Admin\AdminController@index') }}">Home</a></li>
    <li class="active">Users</li>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    @include('layouts._block.session_message');

                    <div class="panel-heading">Users</div>

                    <div class="panel-body">
                        <span class="pull-left">
                            <a href="{{ route('users.create') }}" class="btn btn-primary">Create User</a>
                        </span>
                        <form class="navbar-form navbar-right" method="post" action="search_users">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input type="text" class="form-control" name="text" placeholder="Search">
                            </div>
                            <button type="submit" class="btn btn-default">Search</button>
                        </form>
                        <table class="table table-condensed">
                            <tr>
                                <td id="name">Name</td>
                                <td>Email</td>
                                <td>ApiKey</td>
                                <td>Contact</td>
                            </tr>
                            @if(count($users))
                                @foreach($users as $user)
                                <tr>
                                    <td><a href="{{ route('users.show', [$user->id]) }}">{{ $user->name }}</a></td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->api_key }}</td>
                                    @if(count($user->contacts))
                                        <td>
                                            <table class="table table-condensed">
                                                @foreach($user->contacts as $contact)
                                                    <tr>
                                                        <td>{{ $contact->type }}</td>
                                                        <td>{{ $contact->contact }}</td>
                                                        <td>
                                                            <span class="pull-right">
                                                            @if($contact->notify)
                                                                <a href="{{ action('Admin\AdminController@notify', [$contact->id]) }}" class="btn btn-success btn-sm" data-notify="notify" data-id="{{ $contact->id }}">Notify</a>
                                                            @else
                                                                <a href="{{ action('Admin\AdminController@notify', [$contact->id]) }}" class="btn btn-danger btn-sm" data-notify="notify" data-id="{{ $contact->id }}">Notify</a>
                                                            @endif
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                    @else
                                        <td>Null</td>
                                    @endif
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
                        that.attr('class', 'btn btn-danger btn-sm');
                    } else {
                        that.attr('class', 'btn btn-success btn-sm');
                    }
                },
            });
        });


    });

</script>
@endsection