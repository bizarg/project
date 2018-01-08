<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proxy admin</title>

    <!-- Bootstrap core CSS -->
    <link href="{{URL::asset('assets/css/bootstrap.css')}}" rel="stylesheet">


    <!--WH Fonts icons-->

    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet">

    <script type="text/javascript" src="{{URL::asset('assets/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('assets/js/bootstrap.min.js')}}"></script>
</head>

<body>
<div class="container">
    <div class="row logo">
        <div class="col-md-3">AdminLogo</div>
        <div class="col-md-9"><a class="logout pull-right" href="{{ url('admin/logout') }}">Hi, User! <i
                        class="fa fa-sign-out"></i></a></div>
    </div>
    <div class="strip"></div>

    <div class="row main">
        <div class="col-md-2">
            <ul class="leftmenu">
                <li>
                    <a class="{{ Request::is('admin/users') ? ' active' : null }}" href="{{ url('/admin/users') }}">
                        <i class="fa fa-users"></i> Users
                    </a>
                </li>
                <li>
                    <a class="{{ Request::is('admin/tasks') ? 'active' : null }}" href="{{ url('/admin/tasks') }}">
                        <i class="fa fa-tasks"></i> Tasks
                    </a>
                </li>
                <li>
                    <a class="{{ Request::is('admin/domains') ? 'active' : null }}" href="{{ url('/admin/domains') }}">
                        <i class="fa fa-bars"></i> Domains
                    </a>
                </li>

                <li>
                    <a class="{{ Request::is('admin/nodes') ? 'active' : null }}" href="{{ url('/admin/nodes') }}">
                        <i class="fa fa-cubes"></i> Nodes
                    </a>
                </li>
                <li>
                    <a class="{{ Request::is('admin/sites') ? 'active' : null }}" href="{{ url('/admin/sites') }}">
                        <i class="fa fa-sitemap"></i> Sites
                    </a>
                </li>

            </ul>
        </div>


        @yield('content')


    </div>
</div>

<div class="footer">
    <div class="container">
        <p class="text-muted"></p>
    </div>
</div>

</body>
</html>