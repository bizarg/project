<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{asset('favicon.ico')}}">
    <title>Video Converter</title>
    <!-- Bootstrap core CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">CDN</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                    @if(Auth::check())
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{Auth::user()->name}} <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{route('profile.index')}}">Profile</a></li>
                                <li><a href="{{route('ftp-settings.index')}}">FTP accounts</a></li>
                                <li><a href="{{route('settings.index')}}">Domains</a></li>
                                <li><a href="{{route('templates.index')}}">Templates</a></li>
                                @if(Auth::user()->admin)<li><a href="{{url('admin')}}">Site settings</a></li>@endif
                                <li role="separator" class="divider"></li>
                                <li><a href="{{ url('/logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">Logout</a>
                                </li>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </ul>
                        </li>
                    </ul>
                    @else
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{route('login')}}">Login</a></li>
                        <li><a href="{{url('register')}}">Register</a></li>
                    </ul>
                    @endif

            </div><!--/.navbar-collapse -->
        </div>
    </nav>

    @yield('jumbotron')

    <div class="container">
        @if(Request::path() != '/')
        <ol class="breadcrumb" style="margin-top: 60px">
            @yield('breadcrumb')
        </ol>
        @endif
        @yield('content')
        <hr>
        <footer>
            <p>&copy; 2016 - 2017 CDN Video Converter.</p>
        </footer>
    </div> <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="{{asset('js/jquery.min.js')}}"><\/script>')</script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    @yield('js')
</body>
</html>