@extends('layouts.app_admin')

@section('breadcrumb')
    <li><a href="{{ action('Admin\AdminController@index') }}">Home</a></li>
    <li><a href="{{ route('sites.index') }}">Sites</a></li>
    <li class="active">Edit</li>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Site</div>

                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('sites.update', $site->id) }}">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}

                            <div class="form-group{{ $errors->has('domain') ? ' has-error' : '' }}">
                                <label for="domain" class="col-md-4 control-label">Domain</label>

                                <div class="col-md-6">
                                    <input id="domain" type="text" class="form-control" name="domain" value="{{ $site->domain }}" autofocus>

                                    @if ($errors->has('domain'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('domain') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('main_url') ? ' has-error' : '' }}">
                                <label for="main_url" class="col-md-4 control-label">Main URL</label>

                                <div class="col-md-6">
                                    <input id="main_url" type="text" class="form-control" name="main_url" value="{{ $site->main_url }}" autofocus>

                                    @if ($errors->has('main_url'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('main_url') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('userSites') ? ' has-error' : '' }}">
                                <label for="userSites" class="col-md-4 control-label">User Sites</label>
                                <div class="col-md-6">

                                    <select id="userSites" class="form-control js-example-basic-multiple" name="userSites">
                                        <option value="0" selected>Null</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" @if($user->id == $userSite['user_id']) selected @endif>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('userSites'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('userSites') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
