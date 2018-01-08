@extends('layouts.appAdmin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                @include('errors._sessionBlock')

                <div class="panel panel-default">
                    <div class="panel-heading">User</div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Balance</th>
                                <th>Status</th>
                            </tr>
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->balance }} UAH</td>
                                    @if($user->status)
                                        <td><a href="{{ url('admin/users/status/'.$user->id) }}" class="btn btn-success">Одобрен</a></td>
                                    @else
                                        <td ><a href="{{ url('admin/users/status/'.$user->id) }}" class="btn btn-warning">Не одобрен</a></td>
                                    @endif
                                </tr>
                        </table>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Domains</div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <tr>
                                <th>Create</th>
                                <th>User</th>
                                <th>URL</th>
                                <th>Tariff</th>
                                <th>Value</th>
                                <th>Status</th>
                            </tr>
                            @if(count($user->domains))
                                @foreach($user->domains as $domain)
                                    <tr>
                                        <td>{{ date('d-m-Y', time($domain->created_at)) }}</td>
                                        <td>{{ $domain->user->name }}</td>
                                        <td><a href="{{ action('Admin\DomainController@show', [$domain->id]) }}">{{ $domain->name }}</a></td>
                                        <td>{{ $domain->tariff->name }}</td>
                                        <td>{{ $domain->tariff->value }}</td>
                                        <td style="color:{{ $domain->status->color }}">{{ $domain->status->name }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">No domains</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection