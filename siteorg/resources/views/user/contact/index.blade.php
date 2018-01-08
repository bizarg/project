@extends('layouts.app')

@section('breadcrumb')
    <li><a href="/">Home</a></li>
    <li class="active">My Contacts</li>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                @include('layouts._block.session_message');

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-2"><h4>Contacts</h4></div>
                            <div class="col-md-2 col-md-offset-7">
                                <a class="btn btn-default" href="{{ route('contact.create') }}">Create contact</a>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <table class="table table-bordered">
                            <tr>
                                <td>Type</td>
                                <td>Contact</td>
                                <td colspan="3">Action</td>
                            </tr>
                            @foreach($contacts as $contact)
                                <tr>
                                    <td>{{ $contact->type }}</td>
                                    <td>{{ $contact->contact }}</td>
                                    <td><span class="pull-right">
                                        @if($contact->notify)
                                            <a href="{{ action('User\UserController@notify', [$contact->id]) }}" class="btn btn-success" data-notify="notify" data-id="{{ $contact->id }}">Notify</a>
                                        @else
                                            <a href="{{ action('User\UserController@notify', [$contact->id]) }}" class="btn btn-danger" data-notify="notify" data-id="{{ $contact->id }}">Notify</a>
                                        @endif

                                    <a href="{{ route('contact.edit', [$contact->id]) }}" class="btn btn-primary">Edit</a>

                                        <a href="#" class="btn btn-danger"
                                           onclick="event.preventDefault();document.getElementById('destroy-form').submit();">Delete</a>
                                        <form id="destroy-form" action="{{ route('contact.destroy', [$contact->id]) }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
                                    </span></td>
                                </tr>
                            @endforeach
                        </table>

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
                        console.log(json);
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