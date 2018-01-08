@extends('layouts.appAdmin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create Task</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/create_task') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name Task</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autofocus><p>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">Description</label>
                            <div class="col-md-6">
                                <textarea id="description" type="textarea" class="form-control" name="description" rows='3'>{{ old('description') }}</textarea>                               
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('domen') ? ' has-error' : '' }}">
                            <div class="col-md-6 col-md-offset-3">
                                <ul class="nav nav-tabs" id="myTab">
                                  <li class="active"><a href="#domen" data-toggle="tab">Домен</a></li>
                                  <li><a href="#project" data-toggle="tab">Проект</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="domen">
                                <div class="form-group{{ $errors->has('domen') ? ' has-error' : '' }}">
                                    <label for="domen" class="col-md-4 control-label">Domens</label>
                                    <div class="col-md-6">
                                        <select id="domen" class="form-control" name="domen">
                                            <option value="" selected>Выберите домен</option>
                                            @foreach($domens as $domen)
                                            <option value="{{ $domen->id }}">{{ $domen->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('domen'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('domen') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="project">
                                <div class="form-group{{ $errors->has('project') ? ' has-error' : '' }}">
                                    <label for="Project" class="col-md-4 control-label">Projects</label>
                                    <div class="col-md-6">
                                        <select id="Project" class="form-control" name="project">
                                            <option value="" selected>Выберите проект</option>
                                            @foreach($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('project'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('project') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>   
                            </div>
                        </div>

                        <script>
                          $(function () {
                            $('#myTab a:last').tab('show')
                          })
                        </script>

                        <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                            <label for="datetimepicker" class="col-md-4 control-label">Date</label>
                            <div class="col-md-6">
                                <input type="text" id="datetimepicker" size="30" name="date">

                                @if ($errors->has('date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date') }}</strong>
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
