@extends('layouts.app_admin')

@section('breadcrumb')
    <li><a href="{{ action('Admin\AdminController@index') }}">Home</a></li>
    <li class="active">Proxies</li>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    @include('layouts._block.session_message')

                    <div class="panel-heading">Proxies</div>


                    <div class="panel-body">
                        <span class="pull-left">
                            <a href="{{ url('admin/proxy/create') }}" class="btn btn-primary">Add Proxy</a>
                        </span>


                        <table class="table table-condensed">

                            @foreach($activeProxy as $type => $cnt)
                                <tr>
                                    <td>{{ $type }}</td>
                                    <td>{{ $cnt }}</td>
                                </tr>
                            @endforeach
                        </table>

                        <table class="table table-condensed">
                            <tr>
                                <td id="name"><a href="{{ url('admin/proxies?order=ip') }}">IP</a></td>
                                <td>Port</td>
                                <td><a href="{{ url('admin/proxies?order=type') }}">Type</a></td>
                                <td><a href="{{ url('admin/proxies?order=status') }}">Status</a></td>
                                <td><a href="{{ url('admin/proxies?order=banned') }}">Banned</a></td>
                            </tr>
                            @foreach($proxies as $proxy)
                                <tr>
                                    <td><a href="{{ url('admin/proxy', [$proxy->id]) }}">{{ $proxy->ip }}</a></td>
                                    <td>{{ $proxy->port }}</td>
                                    <td>{{ $proxy->type }}</td>
                                    <td>{{ $proxy->status }}</td>
                                    <td>{{ $proxy->banned }}</td>

                                </tr>
                            @endforeach
                        </table>
                        {{ $proxies->appends(['order' => request()->input('order')])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
