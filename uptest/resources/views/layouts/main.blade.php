<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">--}}

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900&subset=latin,cyrillic'
          rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{URL::asset('assets/css/main.css')}}">
    <!-- vriten -->
</head>
<body>
<div class="wrap-header">
    <div class="container">
        <div class="row">
            <nav class="navbar navbar-light bg-faded">
                <!-- Brand -->
                <a class="navbar-brand" href="/">Load Service</a>


                <ul class="nav navbar-nav pull-right">
                    <li class="nav-item">
                        @if( !Auth::check() )
                            <div class="btn-group">
                                <a class="btn btn-secondary" href="{{ url('/login') }}">Войти</a>
                                <a class="btn btn-secondary" href="{{ url('/register') }}">Регистрация</a>
                            </div>
                        @else
                            <div class="btn-group">
                            @if (preg_match( '/^((?!home).+)$/', Request::path() ) )
                                <a class="btn btn-secondary" href="/domains">Панель управления</a>

                            @endif
                                <a class="btn btn-secondary" href="/monitoring">Мониторинг</a>

                                <a class="btn btn-secondary" href="{{ url('/logout') }}">Выйти</a>
                            </div>
                        @endif


                    </li>
                    <li class="nav-item">
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>


@yield('content')

@include('layouts._layout.footer')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>
