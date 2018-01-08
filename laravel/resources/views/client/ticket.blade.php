@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if(Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif
                @if(Session::has('successfully'))
                    <div class="alert alert-success">
                        {{ Session::get('successfully') }}
                    </div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">Ticket: {{ $ticket->name }}</div>

                    <div class="panel-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
