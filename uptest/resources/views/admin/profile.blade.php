@extends('admin.layouts.admin')

@section('content')

    <div class="col-md-10">


            @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">{{ $error }}</div>
            @endforeach

        <form class="form-horizontal" role="form" method="post" action="{{ url('/admin/user/edit/'.$user->id) }}">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">email</label>

                <div class="col-sm-8">
                    <input type="text" readonly name="email" value="{{ $user->email }}" class="form-control"
                           placeholder="email">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">new password</label>

                <div class="col-sm-8">
                    <input type="text" name="new_password" class="form-control" value="" placeholder="new password">
                </div>
                @if ($errors->has('new_password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('new_password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">role</label>

                <div class="col-sm-8">
                    <select id="role" required name="role"
                            class="btn btn-default form-select">

                            <option value="user" {{ $user->role  == 'user' ? 'selected' : "" }}>user</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : "" }}>admin</option>

                    </select>
                </div>
                @if ($errors->has('role'))
                    <span class="help-block">
                        <strong>{{ $errors->first('role') }}</strong>
                    </span>
                @endif
            </div>



            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default" name="send">Submit</button>
                </div>
            </div>

        </form>

    </div>

@endsection