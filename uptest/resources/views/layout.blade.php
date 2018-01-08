<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>

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
        <div class="col-md-3">Test</div>
        <div class="col-md-offset-2 col-md-5 topmenu">
            <a href="/" class="{{ Request::is('/') ? ' active' : null }}">Main</a>

        </div>
        <div class="col-md-2">Hi

        </div>
    </div>
    <div class="strip"></div>
    @yield('content')
</div>


<div class="footer">
    <div class="container">
        <p class="text-muted">

        </p>
    </div>
</div>
@yield('footer_script')
</body>
</html>