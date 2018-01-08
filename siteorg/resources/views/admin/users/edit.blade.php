@extends('layouts.app_admin')

@section('breadcrumb')
    <li><a href="{{ action('Admin\AdminController@index') }}">Home</a></li>
    <li><a href="{{ route('users.index') }}">Users</a></li>
    <li class="active">Edit</li>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Create User</div>
                    {{--DB::table('users')->insert([--}}
                    {{--'name' => 'admin',--}}
                    {{--'email' => 'admin@admin',--}}
                    {{--'password' => bcrypt('gEjU1D'),--}}
                    {{--'api_key' => 'gEjU1D',--}}
                    {{--'sex' => 'male',--}}
                    {{--]);--}}
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('users.update', $user->id) }}">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">Email</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" value="" autofocus>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('api_key') ? ' has-error' : '' }}">
                                <label for="api_key" class="col-md-4 control-label">API Key</label>

                                <div class="col-md-6">
                                    <input id="api_key" type="text" class="form-control" name="api_key" value="{{ $user->api_key }}" autofocus>

                                    @if ($errors->has('api_key'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('api_key') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('sex') ? ' has-error' : '' }}">
                                <label for="sex" class="col-md-4 control-label">Sex</label>
                                <div class="col-md-6">
                                    <select id="sex" class="form-control" name="sex">
                                        @if($user->sex == 'male')
                                            <option value="male" selected>Male</option>
                                            <option value="female">Female</option>
                                        @else
                                            <option value="male">Male</option>
                                            <option value="female" selected>Female</option>
                                        @endif


                                    </select>

                                    @if ($errors->has('sex'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('sex') }}</strong>
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
