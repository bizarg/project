@extends('layouts.panel')

@section('breadcrumb')
    <li><a href="/">Home</a></li>
    <li><a href="{{ route('templates.index') }}">Templates</a></li>
    <li class="active">Edit</li>
@endsection

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">x</span></button>
            <h4>Success!</h4>
            <p>{{session('success')}}</p>
        </div>
    @elseif (session('fail') or !$errors->isEmpty())
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">x</span></button>
            <h4>Error!</h4>
            <p>{{session('fail')}}</p>
        </div>
    @endif

    <div class="panel panel-default">
        <div class="panel-heading">Template Edit</div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('templates.update', [$template->id]) }}">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}

                <div class="form-group{{ $errors->has('domain') ? ' has-error' : '' }}">
                    <label for="code" class="col-md-4 control-label">Code</label>

                    <div class="col-md-6">
                        <textarea  id="code" class="form-control" name="code" autofocus>{{ $template->code }}</textarea>

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
                            Edit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

