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


    <link href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet">

    <script type="text/javascript" src="{{URL::asset('assets/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('assets/js/bootstrap.min.js')}}"></script>
</head>

<body>
<div class="container">

    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">{{ $error }}</div>
    @endforeach


    <div class="row main form-login">

        <div class="col-md-10">
            <h3>Login</h3>

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/login') }}">
                {{ csrf_field() }}
                <div class="form-group  {{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="inputEmail3" class="col-sm-4 control-label">E-Mail Address</label>

                    <div class="col-sm-6">
                        <input type="text" name="email" class="form-control" placeholder="email"
                               value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>


                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">Password</label>

                    <div class="col-sm-6">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-2">
                        <button type="submit" class="btn btn-default" name="send">Submit</button>
                    </div>
                    <div class=" col-sm-6">
                    <a title="Forget password" href="{{ url('/password/reset') }}">Forget password?</a>
                    </div>
                </div>

            </form>
        </div>


    </div>
</div>


</body>
</html>