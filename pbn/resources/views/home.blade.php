@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-2"><h4>Domains</h4></div>
                    <div class="col-md-2 col-md-offset-7">
                        <a class="btn btn-default" href="{{ action("InstallController@add_domain") }}" id="install">Add</a>
                    </div>
                </div>
            </div>

            <div class="panel-body">

                <table class="table table-bordered">
                    <tr>
                        <th>Domain</th>
                        <th>IP/Country/City</th>
                        <th>WP build</th>
                        <th>NS1,NS2</th>
                    </tr>
                    @foreach($domains as $domain)
                        <tr>
                            <td>{{ $domain->name }}</td>
                            <td>{{ $domain->ip->ip.'/'.$domain->ip->country->name }}</td>
                            <td>{{ $domain->build->name }}</td>
                            <td>{{$domain->ns1->name.', '.$domain->ns2->name}}</td>
                        </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </div>
@endsection



