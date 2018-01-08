@extends('layouts.appAdmin')

@section('breadcrumb')
    <li><a href="{{ action('Admin\AdminController@index') }}">Admin</a></li>
    <li><a href="{{ action('Admin\DomainController@index') }}">Domains</a></li>
    <li class="active">Show Domain</li>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    @include('errors._sessionBlock')

                    <div class="panel-heading">Domain</div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <tr>
                                <th>URL</th>
                                <th>Tariff</th>
                                <th>User</th>
                                <th>Balance</th>
                                <th>Status</th>
                            </tr>
                            <tr>
                                <td>{{ $domain->name }}</td>
                                <td>{{ $domain->tariff->name }}</td>
                                <td>{{ $domain->user->name }}</td>
                                <td>{{ $domain->user->balance }} uah</td>
                                <td style="color:{{ $domain->status->color }}">{{ $domain->status->name }}</td>
                            </tr>
                        </table>
                        <form action="{{ action('Admin\DomainController@update', [$domain->id]) }}" class="form-horizontal" method="post">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('tariff') ? ' has-error' : '' }}">
                                <label for="tariff" class="col-md-4 control-label">Tariff</label>
                                <div class="col-md-6">
                                    <select id="tariff" class="form-control" name="tariff">
                                        @foreach($tariffs as $tariff)
                                            @if($domain->tariff->id == $tariff->id)
                                                <option value="{{ $tariff->id }}" selected>{{ $tariff->name }} {{ $tariff->value }}</option>
                                            @else
                                                <option value="{{ $tariff->id }}">{{ $tariff->name }} {{ $tariff->value }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if ($errors->has('tariff'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('tariff') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                <label for="status" class="col-md-4 control-label">Status</label>
                                <div class="col-md-6">
                                    <select id="status" class="form-control" name="status">
                                        @foreach($statuses as $status)
                                            @if($domain->status->id == $status->id)
                                                <option value="{{ $status->id }}" selected>{{ $status->name }}</option>
                                            @else
                                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('status') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection