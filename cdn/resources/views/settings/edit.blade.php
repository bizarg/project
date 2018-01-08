@extends('layouts.panel')

@section('breadcrumb')
    <li><a href="/">Home</a></li>
    <li><a href="{{route('settings.index')}}">FTP accounts</a></li>
    <li class="active">Edit Domain</li>
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading"><b>Edit Domain</b></div>
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
            <form method="post" action="{{route('settings.update', $domain->id)}}">
                {{csrf_field()}}
                {{method_field('PUT')}}
                <div class="form-group {{ $errors->has('domain') ? 'has-error' : '' }}">
                    <label for="domain">Domain</label>
                    <input type="text" class="form-control" id="domain" value="@if(!empty(old('domain'))){{old('domain')}}@else{{$domain->domain}}@endif" name="domain" @if($errors->has('domain'))aria-describedby="name-help"@endif>
                    @if ($errors->has('domain'))<span id="name-help" class="help-block">{{ $errors->first('domain') }}</span>@endif
                </div>
                <div class="form-group {{ $errors->has('link_format') ? 'has-error' : '' }}">
                    <label for="link_format">Link Format</label>
                    <input type="text" class="form-control" id="link_format" value="@if(!empty(old('link_format'))){{old('link_format')}}@else{{$domain->link_format}}@endif" name="link_format" @if($errors->has('link_format'))aria-describedby="address-help"@endif>
                    @if ($errors->has('link_format'))<span id="address-help" class="help-block">{{ $errors->first('link_format') }}</span>@endif
                </div>
                <button type="submit" class="btn btn-default">Save</button>
            </form>
        </div>
    </div>
@endsection

@push('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active">Library</li>
@endpush