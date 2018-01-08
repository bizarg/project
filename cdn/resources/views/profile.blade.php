@extends('layouts.panel')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Home</a></li>
    <li class="breadcrumb-item active">Profile</li>
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading"><b>Profile</b></div>
        <div class="panel-body">
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    <h4>Saved!</h4>
                    <p>Changes saved successfully.</p>
                </div>
            @elseif (Session::has('fail') or !$errors->isEmpty())
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    <h4>Error!</h4>
                    <p>An error occurred while saving the profile.</p>
                </div>
            @endif
            <form method="post" action="{{route('profile.store')}}">
                {{csrf_field()}}
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" value="{{Auth::user()->email}}" name="email" @if($errors->has('email'))aria-describedby="email-help"@endif>
                    @if ($errors->has('email'))<span id="email-help" class="help-block">{{ $errors->first('email') }}</span>@endif
                </div>
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" value="{{Auth::user()->name}}" name="name" @if($errors->has('name'))aria-describedby="name-help"@endif>
                    @if ($errors->has('name'))<span id="name-help" class="help-block">{{ $errors->first('name') }}</span>@endif
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Password" name="password" @if($errors->has('password'))aria-describedby="password-help"@endif>
                    @if ($errors->has('password'))<span id="password-help" class="help-block">{{ $errors->first('password') }}</span>@endif
                </div>
                <div class="form-group {{ $errors->has('password_confirm') ? 'has-error' : '' }}">
                    <label for="password_confirm">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirm" placeholder="Confirm Password" name="password_confirm" @if($errors->has('password_confirm'))aria-describedby="password_confirm-help"@endif>
                    @if ($errors->has('password_confirm'))<span id="password_confirm-help" class="help-block">{{ $errors->first('password_confirm') }}</span>@endif
                </div>
                <button type="submit" class="btn btn-default">Save</button>
            </form>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading"><b>FTP accounts</b></div>
        <div class="panel-body">
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    <h4>Saved!</h4>
                    <p>{{session('success')}}</p>
                </div>
            @elseif (Session::has('fail') or !$errors->isEmpty())
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    <h4>Error!</h4>
                    <p>{{session('fail')}}</p>
                </div>
            @endif

            <div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Port</th>
                        <th>Directory</th>
                        <th>login</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody id="upload_files">
                        @forelse($ftps as $acc)
                            <tr>
                                <td><b>{{$acc->name}}</b></td>
                                <td><b>{{$acc->adr}}</b></td>
                                <td><b>{{$acc->port or 'standart'}}</b></td>
                                <td><b>{{$acc->dir or 'root directory'}}</b></td>
                                <td><b>{{$acc->login}}</b></td>
                                <td>
                                    <form action="{{route('ftp-settings.destroy', $acc->id)}}" method="POST">
                                        {{csrf_field()}}
                                        {{method_field('DELETE')}}
                                        <a href="{{route('ftp-settings.edit', $acc->id)}}"><span class="glyphicon glyphicon-edit text-info" aria-hidden="true"></span></a>
                                        <a href="#!"><span class="glyphicon glyphicon-remove text-danger" aria-hidden="true" data-target="delete"></span></a>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">You haven't ftp accounts. <a href="{{route('ftp-settings.create')}}">Add account</a></td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
            <a href="{{route('ftp-settings.create')}}" class="btn btn-primary pull-right">Add new</a>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading"><b>Domains</b></div>
        <div class="panel-body">
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    <h4>Saved!</h4>
                    <p>{{session('success')}}</p>
                </div>
            @elseif (Session::has('fail') or !$errors->isEmpty())
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    <h4>Error!</h4>
                    <p>{{session('fail')}}</p>
                </div>
            @endif

            <div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody id="domain">
                    @forelse($domains as $domain)
                        <tr>
                            <td><b>{{$domain->domain}}</b></td>
                            <td>
                                <form action="{{route('settings.destroy', $domain->id)}}" method="POST">
                                    {{csrf_field()}}
                                    {{method_field('DELETE')}}
                                    <a href="{{route('settings.edit', $domain->id)}}"><span class="glyphicon glyphicon-edit text-info" aria-hidden="true"></span></a>
                                    <a href="#!"><span class="glyphicon glyphicon-remove text-danger" aria-hidden="true" data-target="delete"></span></a>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">You haven't domains. <a href="{{route('settings.create')}}">Add account</a></td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
            </div>
            <a href="{{route('settings.create')}}" class="btn btn-primary pull-right">Add new</a>
        </div>
    </div>
    {{--<div class="panel panel-default">--}}
        {{--<div class="panel-heading"><b>Custom resolution</b></div>--}}
        {{--<div class="panel-body">--}}
            {{--<form action="{{ action('PanelController@storeResolution') }}" method="POST">--}}
                {{--{{csrf_field()}}--}}
                {{--<div class="form-group">--}}
                    {{--<label for="weight" class="col-md-1 control-label">Weight</label>--}}
                    {{--<div class="col-md-2">--}}
                        {{--<input class="form-control" type="text" id="weight" name="weight" value="{{ old('weight') }}">--}}
                        {{--@if($errors->has('weight'))--}}
                            {{--<span class="help-block">--}}
                            {{--<strong>{{ $errors->first('weight') }}</strong>--}}
                        {{--</span>--}}
                        {{--@endif--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                    {{--<label for="height" class="col-md-1 control-label">Height</label>--}}
                    {{--<div class="col-md-2">--}}
                        {{--<input class="form-control" type="text" id="height" name="height" value="{{ old('height') }}">--}}
                        {{--@if($errors->has('height'))--}}
                            {{--<span class="help-block">--}}
                            {{--<strong>{{ $errors->first('weight') }}</strong>--}}
                        {{--</span>--}}
                        {{--@endif--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="form-group">--}}
                    {{--<div class="col-md-2 col-md-offset-4">--}}
                        {{--<button type="submit" class="btn btn-primary pull-right">--}}
                            {{--Add--}}
                        {{--</button>--}}
                    {{--</div>--}}
                {{--</div>--}}

            {{--</form>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="panel panel-default">--}}
        {{--<div class="panel-heading"><b>Custom bitrate</b></div>--}}
        {{--<div class="panel-body">--}}
            {{--<form action="{{ action('PanelController@storeBitrate') }}" method="POST">--}}
                {{--{{csrf_field()}}--}}
                {{--<div class="form-group">--}}
                    {{--<label for="bitrate" class="col-md-1 control-label">Bitrate</label>--}}
                    {{--<div class="col-md-2">--}}
                        {{--<input class="form-control" type="text" id="bitrate" name="bitrate" value="{{ old('bitrate') }}">--}}
                        {{--@if($errors->has('bitrate'))--}}
                            {{--<span class="help-block">--}}
                            {{--<strong>{{ $errors->first('bitrate') }}</strong>--}}
                        {{--</span>--}}
                        {{--@endif--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                    {{--<div class="col-md-2 col-md-offset-7">--}}
                        {{--<button type="submit" class="btn btn-primary pull-right">--}}
                            {{--Add--}}
                        {{--</button>--}}
                    {{--</div>--}}
                {{--</div>--}}

            {{--</form>--}}
        {{--</div>--}}
    {{--</div>--}}
@endsection
@section('js')
    <script>
        // click delete icon
        $("span[data-target=delete]").click(function (e) {
            deleteFile(e, $(this));
        });

        function deleteFile(e, obj) {
            if (!confirm('Are you sure?\nThis operation deleted this ftp account!')) {
                e.preventDefault();
            } else {
                var form = obj.parents('form:first');
                form.submit();
            }
        }
    </script>
@endsection