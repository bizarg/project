@extends('layouts.panel')

@section('breadcrumb')
    <li><a href="/">Home</a></li>
    <li><a href="{{route('settings.index')}}">Domains</a></li>
    <li class="active">Add Domain</li>
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading"><b>Add Domain</b></div>
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
            <form method="post" action="{{route('settings.store')}}">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('domain') ? 'has-error' : '' }}">
                    <label for="domain">Domain</label>
                    <input type="text" class="form-control" id="domain" placeholder="domain" @if(!empty(old('domain')))value="{{ old('domain') }}"@endif name="domain" @if($errors->has('domain'))aria-describedby="domain-help"@endif>
                    @if ($errors->has('domain'))<span id="domain-help" class="help-block">{{ $errors->first('domain') }}</span>@endif
                </div>
                <div class="form-group {{ $errors->has('link_format') ? 'has-error' : '' }}">
                    <label for="link_format">Link Format</label>
                    <input type="text" class="form-control" id="link_format" placeholder="Link format" @if(!empty(old('link_format')))value="{{ old('link_format') }}"@endif name="link_format" @if($errors->has('link_format'))aria-describedby="link_format-help"@endif>
                    @if ($errors->has('link_format'))<span id="link_format-help" class="help-block">{{ $errors->first('link_format') }}</span>@endif
                </div>
                <button type="submit" class="btn btn-default">Save</button>
            </form>
        </div>
    </div>
@endsection