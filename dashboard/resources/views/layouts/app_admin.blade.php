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
</head>
<body>
<div id="app">

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
                            @if (Auth::guard('admin')->check())

                                <li class="dropdown">
                                    <a href="{{ route('admin.logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ trans('app.Logout') }}  {{ Auth::guard('admin')->user()->name }}
                                    </a>
                                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                                </li>
                            @endif
                        </ul>

                    </div>

                </div>
            </nav>
        </div>
        <!-- end header nav-->
    </header>

    <div class="container">
        @if(Request::path() != '/')
            <ol class="breadcrumb">
                @yield('breadcrumb')
            </ol>
        @endif
        @yield('content')
    </div>

</div>
@yield('js')
</body>
</html>
