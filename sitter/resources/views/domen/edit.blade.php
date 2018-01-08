@extends('layouts.appAdmin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Domen</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('domen/edit/'.$domen->id) }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name Domen</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $domen->name }}" autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('marker') ? ' has-error' : '' }}">
                            <label for="marker" class="col-md-4 control-label">Marker</label>

                            <div class="col-md-6">
                                <input id="marker" type="text" class="form-control" name="marker" value="{{ $domen->marker }}">

                                @if ($errors->has('marker'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('marker') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
                            <label for="priority" class="col-md-4 control-label">Priority</label>

                            <div class="col-md-6">
                                <input id="priority" type="text" class="form-control" name="priority" value="{{ $domen->priority }}" autofocus>

                                @if ($errors->has('priority'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('priority') }}</strong>
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
