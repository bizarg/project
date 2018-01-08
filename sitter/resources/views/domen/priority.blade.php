@extends('layouts.appAdmin')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Domen name: {{ $name }} </h4></div>
                <div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="{{ url('domen/priority/'.$domen_id.'/'.$project_id) }}">
	                        {{ csrf_field() }}
	                    <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
	                        <label for="priority" class="col-md-4 control-label">Priority</label>

	                        <div class="col-md-6">
	                            <input id="priority" type="text" class="form-control" name="priority" value="{{ $pivot->priority }}" autofocus>

	                            @if ($errors->has('priority'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('priority') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                    </div>

	                    <div class="form-group{{ $errors->has('marker') ? ' has-error' : '' }}">
	                        <label for="marker" class="col-md-4 control-label">Marker</label>

	                        <div class="col-md-6">
	                            <input id="marker" type="text" class="form-control" name="marker" value="{{ $marker }}">

	                            @if ($errors->has('marker'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('marker') }}</strong>
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