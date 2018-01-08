@extends('layouts.app_admin')

@section('breadcrumb')
    <li><a href="{{ action('Admin\AdminController@index') }}">Home</a></li>
    <li class="active">Sites</li>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    @include('layouts._block.session_message');

                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-3"><h4>Sites</h4></div>
                            <div class="col-md-2 col-md-offset-6">
                                <a href="{{ route('sites.create') }}" class="btn btn-primary">Create Site</a>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">

                        <form class="navbar-form navbar-right" method="post" action="search_sites">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input type="text" class="form-control" name="text" placeholder="Search">
                            </div>
                            <button type="submit" class="btn btn-default">Search</button>
                        </form>

                        <table class="table">
                            <tr>
                                <td>
                                    Domain
                                </td>
                                <td>
                                    MainUrl
                                </td>
                                <td>Edit Main URL</td>
                                <td>Action</td>
                            </tr>

                            @foreach($sites as $site)
                                <tr>
                                    <td><a href="{{ route('sites.show', [$site->id]) }}">{{ $site->domain }}</a></td>
                                    <td>{{ $site->main_url }}</td>
                                    <td>
                                        <form action="{{ action('Admin\AdminController@edit_main_url', [$site->id]) }}" data-url='edit' method="POST">
                                        {{ csrf_field() }}
                                        <input type="text" name="url" value="">
                                        <input type='submit' class="btn btn-primary submit" value="Edit">
                                        </form>
                                    </td>
                                    <td><a href="{{ route('sites.edit', [$site->id]) }}" class="btn btn-primary">Edit</a>

                                        <a href="#" class="btn btn-danger" onclick="event.preventDefault();document.getElementById('destroy-form{{ $site->id }}').submit();">Delete</a>
                                        <form id="{{ 'destroy-form'.$site->id }}" action="{{ route('sites.destroy', $site->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $sites->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
<script>

    $(document).ready(function(){

        $("[data-url='edit']").on('submit', function(e){
            e.preventDefault();

            var form = $(this);
            var insert = form.parent().prev();
            var formData = new FormData(form.get(0));

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                success: function(json){
                    console.log(insert.text(json));
                },
            });
        });


    });

</script>

@endsection

