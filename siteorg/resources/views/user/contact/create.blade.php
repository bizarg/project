@extends('layouts.app')

@section('breadcrumb')
    <li><a href="/">Home</a></li>
    <li><a href="{{ route('contact.index') }}">My Contacts</a></li>
    <li class="active">Create</li>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">New Contact</div>

                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('contact.store') }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                <label for="{{ 'type' }}" class="col-md-4 control-label">Type</label>
                                <div class="col-md-6">

                                    <select id="type" class="form-control js-example-basic-multiple" name="type">
                                        <option value="phone">Phone</option>
                                        <option value="mobile">Mobile</option>
                                        <option value="viber">Viber</option>
                                        <option value="icq">ICQ</option>
                                        <option value="telegraf">Telegraf</option>
                                        <option value="jabber">Jabber</option>
                                    </select>
                                    @if ($errors->has('type'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('number') ? ' has-error' : '' }}">
                                <label for="contact" class="col-md-4 control-label">Number</label>

                                <div class="col-md-6">
                                    <input id="contact" type="text" class="form-control" name="contact" value="{{ old('contact') }}">

                                    @if($errors->has('number'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('contact') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Create
                                </button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection