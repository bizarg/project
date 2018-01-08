@extends('layouts.app_admin')

@section('breadcrumb')
    <li><a href="{{ action('Admin\AdminController@index') }}">Home</a></li>
    <li><a href="{{ route('admins.index') }}">Admins</a></li>
    <li class="active">Create</li>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-3"><h4>Screenshots</h4></div>
                        <div class="col-md-6 col-md-offset-2">
                            <div class="row">
                                <form class="form-horizontal" role="form" method="POST" action="{{ action('Admin\HistoryController@screenshots_search', [$site_id]) }}">
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
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        @if(count($screenshots))
                            <tr>
                                <th>Screenshots</th>
                                <th>Date</th>
                            </tr>
                            @foreach($screenshots as $s)
                                <tr>
                                    <td>{{ $s->screenshot}}</td>
                                    <td>{{ $s->created_at}}</td>
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


