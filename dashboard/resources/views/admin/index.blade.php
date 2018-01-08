@extends('layouts.app_admin')

@section('content')

@foreach ($errors->all() as $error)
<div class="alert alert-danger" role="alert">{{ $error }}</div>
@endforeach

@if(session('success'))
<div class="alert alert-success" role="alert">
    <h4>Success!</h4>
    <p>{{session('success')}}</p>
</div>
@elseif (session('fail'))
<div class="alert alert-danger" role="alert">
    <h4>Error!</h4>
    <p>{{session('fail')}}</p>
</div>
@endif


<h1 class="dash_title">Admin Panel</h1>
<div class="row">
    <form action="{{ action('Admin\AdminController@search_user') }}" method="post">
        {{ csrf_field() }}
        <div class="row">
            <div class="input-field col s6">
                <i class="material-icons prefix">link</i>
                <input id="icon_telephone" class="validate" name="search" type="text" placeholder="{{ trans('app.Search') }}">
                <label for="icon_telephone"></label>
            </div>
            <div class="input-field col s6">
                <p class="waves-effect waves-light right orangebtn btn">
                    <input type="submit" value="{{ trans('app.Search') }}">
                </p>
            </div>
        </div>
    </form>
</div>
<table class="bordered">
    <thead>
    <tr>
        <th style="text-align: center;">Login</th>
        <th style="text-align: center;">Id</th>
        <th style="text-align: center;">Token</th>
        <th style="text-align: center;">Email</th>
        <th style="text-align: center;">Action</th>
    </tr>
    </thead>
    <tbody id="body">
    @foreach($users as $user)
        <tr>
            <td style="text-align: center">{{ $user->amhost_login }}</td>
            <td style="text-align: center">{{ $user->amhost_id }}</td>
            <td style="text-align: center;font-size: 12px" data-id="{{$user->id}}">{{ $user->login_token }}</td>
            <td style="text-align: center">{{ $user->email }}</td>
            <td style="text-align: center"><a href="{{ action('Admin\AdminController@generate_token', [$user->id]) }}" data-generate="generate" class="btn ">Generate</a></td>
        </tr>
    @endforeach
    </tbody>
</table>

<div>
    @if(count($users))
    {{ $users->links() }}
    @endif
</div>

@endsection

@section('js')
<script>

    $(document).ready(function(){


            $("[data-generate='generate']").click(function(e) {
                e.preventDefault();

                var that = $(this);

                $.ajax({
                    url: that.attr('href'),
                    type: 'get',
                    success: function(json){
                        console.log(json);
                       $('[data-id=' + json.id + ']').text(json.token);
                    },
                });
            });



    }); //ready
</script>
@endsection