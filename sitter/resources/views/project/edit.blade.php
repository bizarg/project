@extends('layouts.appAdmin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Update Project</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/project/edit/'.$project->id) }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name Project</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $project->name }}" autofocus>

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
                                <textarea id="description" type="textarea" class="form-control" name="description" rows='3' value="">{{ $project->description }}</textarea>                               
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('users') ? ' has-error' : '' }}">
                            <label for="user" class="col-md-4 control-label">Assistants</label>
                            <div class="col-md-6">
                                <select multiple="multiple" id="user" class="form-control" name="users_delete[]">
                                    
                                	@foreach($assistants as $assistant)
                                        @if($assistant->id == $user->id)continue
                                        @else
                                            {{$res = $assistant->projects()->where('projects.id', $project->id)->get()}}
                                            @if(count($res))
                                                <option value="{{ $assistant->id }}" selected>{{ $assistant->name }}</option>
                                            @else
                                                <option value="{{ $assistant->id }}">{{ $assistant->name }}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('users_delete'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('users_delete') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

						<div class="form-group{{ $errors->has('domens') ? ' has-error' : '' }}">
                            <label for="domen" class="col-md-4 control-label">Domens</label>
                            <div class="col-md-6">
                                <select multiple="multiple" id="domen" class="form-control" name="domens_delete[]">
                                    @foreach($user->domens as $domen)
                                        {{ $res = $domen->projects()->where('projects.id', $project->id)->get() }}
                                        @if(count($res))
                                            <option value="{{ $domen->id }}" selected>{{ $domen->name }}</option>
                                        @else
                                            <option value="{{ $domen->id }}">{{ $domen->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('domens_delete'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('domens_delete') }}</strong>
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
