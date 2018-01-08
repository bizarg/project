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
                <div class="panel-heading">Domains ({{count($user->domens)}})</div>

                <div class="panel-body">
                    <table class="table table-striped">
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                        </tr>
                        @if(count($user->domens))
                            @foreach($user->domens as $domen)
                                <tr>
                                    <td>{{ $domen->name }}</td>
                                    <td>{{ $domen->description }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr colspan="2">
                                <td>To add a domain name, create ticket</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Tickets</div>
                <a href="{{ url('client/create_ticket') }}" class="btn btn-default active" role="button">New Tickets</a>
                <div class="panel-body">
                    <table class="table table-striped">
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                        </tr>
                        @foreach($user->tickets as $ticket)
                        <tr>
                            <td><a href="{{ url('client/ticket/'.$ticket->id) }}">{{ $ticket->name }}</a></td>
                            @if($ticket->status)
                                <td><span  style="color:#555555">Ready</span></td>
                            @else
                                <td ><span  style="color:#c12e2a">Underway</span></td>
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
