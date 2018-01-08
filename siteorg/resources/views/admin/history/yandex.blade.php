@extends('layouts.app_admin')

@section('breadcrumb')
    <li><a href="{{ action('Admin\AdminController@index') }}">Home</a></li>
    <li><a href="{{ route('sites.index') }}">Sites</a></li>
    <li class="active">History</li>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-3"><h4>Yandex</h4></div>
                        <div class="col-md-6 col-md-offset-2">

                                <form class="form-horizontal" role="form" method="POST" action="{{ action('Admin\HistoryController@yandex_search', [$site_id]) }}">
                                    {{ csrf_field() }}
                                    <table class="table">
                                        <tr>
                                            <td>
                                                <div class="form-group{{ $errors->has('from') ? ' has-error' : '' }}">
                                                    <input type="date" id="from" name="from" class="form-control">
                                                    @if ($errors->has('from'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('from') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group{{ $errors->has('to') ? ' has-error' : '' }}">
                                                    <input type="date" id="to" name="to" class="form-control">
                                                    @if ($errors->has('to'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('to') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="col-md-8 col-md-offset-4">
                                                        <button type="submit" class="btn btn-primary">
                                                            Search
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        @if(count($yandex))
                            <tr>
                                <th>Yaca</th>
                                <th>Yaca Theme</th>
                                <th>Tic</th>
                                <th>Created date</th>
                            </tr>
                            @foreach($yandex as $y)
                            <tr>
                                    <td>{{ $y->yaca }}</td>
                                    <td>{{ $y->yaca_theme }}</td>
                                    <td>{{ $y->tic }}</td>
                                    <td>{{ $y->created_at }}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr><td>Null</td></tr>
                        @endif
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection


