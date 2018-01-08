@extends('layouts.appAdmin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create Project</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/project') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name Project</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">Description</label>

                            <div class="col-md-6">
                                <textarea id="description" type="textarea" class="form-control" name="description" rows='3' value="">{{ old('description') }}</textarea>                               
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('users') ? ' has-error' : '' }}">
                            <label for="addUser" class="col-md-4 control-label">Names Assistants</label>
                            <div class="col-md-6">
                                <select multiple="multiple" id="addUser" class="form-control" name="users[]">
                                    @foreach($users as $user)                              
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('users'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('users') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('domens') ? ' has-error' : '' }}">
                            <label for="addDomen" class="col-md-4 control-label">Domens</label>
                            <div class="col-md-6">
                                <select multiple="multiple" id="addDomen" class="form-control" name="domens[]">
                                    @foreach($domens as $domen)
                                    <option value="{{ $domen->id }}">{{ $domen->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('domens'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('domens') }}</strong>
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
        </div>
    </div>
</div>
@endsection
