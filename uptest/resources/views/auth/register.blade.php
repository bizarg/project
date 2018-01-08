@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <div class="account-wall">
                    <h2 class="text-center">Регистрация</h2>

                    <form class="form-signin" role="form" method="POST" action="{{ url('/register') }}">
                        {!! csrf_field() !!}
                        <input type="text"
                               class="form-control top-form"
                               name="name"
                               placeholder="Фамилия Имя"
                               maxlength=255
                               required
                               autofocus/>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif
                        <input type="email"
                               class="form-control center-form"
                               name="email"
                               maxlength=255

                               placeholder="Электронная почта"
                               required/>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                        <input type="password"
                               class="form-control"
                               name="password"
                               maxlength=255
                               placeholder="Пароль" required>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                        <input type="password"
                               class="form-control"
                               name="password_confirmation"

                               placeholder="Подтверждение пароля"
                               maxlength=255

                               required>
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                        @endif


                        <br>
                        <button class="btn btn-primary btn-block btn-lg"
                                ng-click="SUC.signUp()" type="submit">Зарегистрироваться
                        </button>
                    </form>
                </div>
                <a href="{{ url('/login') }}" class="text-center new-account">Войти</a>
            </div>
        </div>
    </div>
@endsection


