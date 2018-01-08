<!DOCTYPE html>
<html lang="en" ng-app="app">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{URL::asset('assets/css/app.css')}}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
     <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js"></script>

</head>
<body ng-controller="MainController">

<nav class="navbar navbar-default">
    <div class="container">
        <div class="container-fluid">
            <!-- Brand -->
            <a class="navbar-brand" href="/">Load Service</a>
            <a class="navbar-brand" href="{{ url('monitoring') }}">Speed monitoring</a>
            <a class="navbar-brand" href="#">Comming soon</a>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item">
                    @if( !Auth::check() )
                        <div class="btn-group">
                            <a class="btn btn-primary navbar-btn" href="{{ url('/login') }}">Войти</a>
                            <a class="btn btn-primary navbar-btn" href="{{ url('/register') }}">Регистрация</a>
                        </div>
                    @else
                        <div class="btn-group">
                            <a class="btn btn-primary navbar-btn" href="{{ url('/logout') }}">Выйти</a>
                        </div>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">




    @yield('content')

    @include('layouts._layout.footer')

</div>
</body>
</html>

