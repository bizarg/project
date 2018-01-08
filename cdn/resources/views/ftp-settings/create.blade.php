@extends('layouts.panel')

@section('breadcrumb')
    <li><a href="/">Home</a></li>
    <li><a href="{{route('ftp-settings.index')}}">FTP accounts</a></li>
    <li class="active">Add FTP account</li>
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading"><b>Add FTP account</b></div>
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
            <form method="post" action="{{route('ftp-settings.store')}}">
                {{csrf_field()}}
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="name" @if(!empty(old('name')))value="{{ old('name') }}"@endif name="name" @if($errors->has('name'))aria-describedby="name-help"@endif>
                    @if ($errors->has('name'))<span id="name-help" class="help-block">{{ $errors->first('name') }}</span>@endif
                </div>
                <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" placeholder="address" @if(!empty(old('address')))value="{{ old('address') }}"@endif name="address" @if($errors->has('address'))aria-describedby="address-help"@endif>
                    @if ($errors->has('address'))<span id="address-help" class="help-block">{{ $errors->first('address') }}</span>@endif
                </div>
                <div class="form-group {{ $errors->has('port') ? 'has-error' : '' }}">
                    <label for="port">Port</label>
                    <input type="text" class="form-control" id="port" placeholder="port" @if(!empty(old('port')))value="{{ old('port') }}"@endif name="port" @if($errors->has('port'))aria-describedby="port-help"@endif>
                    @if ($errors->has('port'))<span id="port-help" class="help-block">{{ $errors->first('port') }}</span>@endif
                </div>
                <div class="form-group {{ $errors->has('dir') ? 'has-error' : '' }}">
                    <label for="dir">Directory path for saving converted files</label>
                    <input type="text" class="form-control" id="dir" placeholder="/public_html/convert_files" @if(!empty(old('dir')))value="{{ old('dir') }}"@endif name="dir" @if($errors->has('dir'))aria-describedby="dir-help"@endif>
                    @if ($errors->has('dir'))<span id="dir-help" class="help-block">{{ $errors->first('dir') }}</span>@endif
                </div>
                <div class="form-group {{ $errors->has('login') ? 'has-error' : '' }}">
                    <label for="login">Login</label>
                    <input type="text" class="form-control" id="login" placeholder="login" @if(!empty(old('login')))value="{{ old('login') }}"@endif name="login" @if($errors->has('login'))aria-describedby="login-help"@endif>
                    @if ($errors->has('login'))<span id="address-help" class="help-block">{{ $errors->first('login') }}</span>@endif
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="password" @if(!empty(old('password')))value="{{ old('password') }}"@endif name="password" @if($errors->has('password'))aria-describedby="password-help"@endif>
                    @if ($errors->has('password'))<span id="password-help" class="help-block">{{ $errors->first('password') }}</span>@endif
                </div>
                <button type="submit" class="btn btn-default">Save</button>
            </form>
        </div>
    </div>
@endsection