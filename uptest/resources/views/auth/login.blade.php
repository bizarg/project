@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <div class="account-wall">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('warning'))
                        <div class="alert alert-warning">
                            {{ session('warning') }}
                        </div>
                    @endif
                    <h2 class="text-center">Авторизация</h2>

                    <form class="form-signin" role="form" method="POST" action="{{ url('/login') }}">
                        {!! csrf_field() !!}
                        <input name="email"
                               type="text"
                               class="form-control top-form"
                               placeholder="Email"
                               required
                               autofocus/>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                        <input name="password"
                               type="password"
                               class="form-control down-form"
                               placeholder="Password"
                               required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                        <br>
                        <button
                                class="btn btn-primary btn-block btn-lg"
                                type="submit"

                        >Войти
                        </button>
                    </form>
                </div>
                <a class="text-center new-account" href="{{ url('/register') }}">Зарагистрироваться</a>
                <a class="btn btn-link" href="{{ url('/password/reset') }}">Забыли пароль?</a>
            </div>
        </div>
    </div>
@endsection




