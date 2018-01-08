@extends('layouts.main')

@section('content')
    <h3 class="dash_title">Add domain</h3>
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">{{ $error }}</div>
    @endforeach
    <div class="settings">
        <div class="row">
            <form class="col s12" method="post" action="{{ url('domain/add') }}">
                {{ csrf_field() }}
                <div class="row">
                    {{--<div class="input-field col s6">--}}
                    {{--<i class="material-icons prefix">email</i>--}}
                    {{--<input id="icon_prefix" type="text" class="validate">--}}
                    {{--<label for="icon_prefix">Email for alert and reports</label>--}}
                    {{--</div>--}}
                    <div class="input-field col s6">
                        <i class="material-icons prefix">link</i>
                        <input id="icon_telephone" class="validate" name="domain" value="{{ old('domain') }}" placeholder="Domain">
                        <label for="icon_telephone"></label>
                    </div>
                    <div class="input-field col s6">
                        <p class="waves-effect waves-light right orangebtn btn"><input type="submit" value="Add"></p>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection
