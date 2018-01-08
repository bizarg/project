@extends('layouts.panel')

@section('breadcrumb')
    <li><a href="/">Home</a></li>
    <li><a href="{{ route('templates.index') }}">Templates</a></li>
    <li class="active">Create</li>
@endsection

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-3"><h4>Templates</h4></div>
                <div class="col-md-2 col-md-offset-6">
                    <a href="{{ route('templates.create') }}" class="btn btn-default">Create Template</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('templates.store') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('domain') ? ' has-error' : '' }}">
                    <label for="code" class="col-md-4 control-label">Code</label>

                    <div class="col-md-6">
                        <textarea  id="code" class="form-control" name="code" autofocus></textarea>

                        @if ($errors->has('code'))
                            <span class="help-block">
                                <strong>{{ $errors->first('code') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Create
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

