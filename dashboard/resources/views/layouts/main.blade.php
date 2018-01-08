<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ url('css/app.css') }}">
    <link rel="stylesheet" href="{{ url('css/style.css') }}">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="{{ url('js/app.js') }}"></script>
    <script src="{{ url('js/script.js') }}"></script>
    <script src="{{ url('js/highcharts.js') }}"></script>
    {{--<script src="https://code.highcharts.com/highcharts.js"></script>--}}
</head>

<body>

<header id="header" class="page-topbar">
    <!-- start header nav-->
    <div class="navbar-fixed">
        <nav class="navbar-color">
            <div class="nav-wrapper">
                <div class="container">
                    <a href="{{ url('/') }}" class="brand-logo">
                        <img src="https://amhost.net/statical/img/logo.png" width="150">
                    </a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li><a href="{{ url('/faq') }}">{{ trans('app.Help') }}</a></li>
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">{{ trans('app.Login') }}</a></li>

                        @else

                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ trans('app.Logout') }}  {{ Auth::user()->email }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        @endif
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle lang-drop" data-toggle="dropdown" role="button"
                               aria-expanded="false" style="width: 100px;text-align: center;">
                                {{ trans('app.test') }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu lang-menu" role="menu" style="display: none">
                                <li><a href="#" class="languageSwitcher" data-locale="en">En</a></li>
                                <li><a href="#" class="languageSwitcher" data-locale="ru">Ru</a></li>
                            </ul>
                        </li>
                    </ul>

                </div>

            </div>
        </nav>
    </div>
    <!-- end header nav-->
</header>

<nav class="main-menu">
    <ul>

        @section('menu')

            <li>
                <a href="{{ url('/') }}">
                    <i class="material-icons fa">dashboard</i>
                    <span class="nav-text">
                            {{ trans('app.Home') }}
                        </span>
                </a>

            </li>
            <li class="has-subnav">
                <a href="{{ url('/settings') }}">
                    <i class="material-icons fa">
                        settings
                    </i>
                    <span class="nav-text">
                       {{ trans('app.AddDomain') }}
                    </span>
                </a>
            </li>

        @show
    </ul>
    @if (!Auth::guest())
        <ul class="logout">
            <li>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                >
                    <i class="fa fa-power-off fa-2x"></i>
                    <span class="nav-text">
                    Logout {{ Auth::user()->email }}
                </span>
                </a>
            </li>
        </ul>
    @endif
</nav>
<a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
<main>
    <div class="container">
        @yield('content')
    </div>
</main>

@yield('js')
</body>
</html>