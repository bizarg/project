@extends('layouts.appAdmin')

@section('breadcrumb')
    <li><a href="{{ action('Admin\AdminController@index') }}">Admin</a></li>
    <li class="active">Domains</li>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                @include('errors._sessionBlock')

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
                                <th>Delete</th>
                            </tr>
                            @if(count($domains))
                                @foreach($domains as $domain)
                                    <tr>
                                        <td>{{ date('d-m-Y', time($domain->created_at)) }}</td>
                                        <td>{{ $domain->user->name }}</td>
                                        <td><a href="{{ action('Admin\DomainController@show', [$domain->id]) }}">{{ $domain->name }}</a></td>
                                        <td>{{ $domain->tariff->name }}</td>
                                        <td>{{ $domain->tariff->value }}</td>
                                        <td style="color:{{ $domain->status->color }}">{{ $domain->status->name }}</td>
                                        <td>
                                            <a href="{{ action('Admin\DomainController@destroy', [$domain->id]) }}" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">No domains</td>
                                </tr>
                            @endif
                        </table>
                        <?php echo $domains->links(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection