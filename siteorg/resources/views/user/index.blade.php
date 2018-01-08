@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Sites</div>

                <div class="panel-body">

                    <form class="navbar-form navbar-right" method="post" action="{{ action('User\SearchController@search_sites') }}">
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
                            <td>Edit</td>
                            <td>Action</td>
                        </tr>
                        @foreach($sites as $site)
                            <tr>
                                <td><a href="{{ action('User\UserController@show_site', [$site->id]) }}">{{ $site->domain }}</a></td>
                                <td>{{ $site->main_url }}</td>
                                <td>
                                    <form action="{{ action('User\SiteController@edit_main_url', [$site->id]) }}" data-url='edit' method="POST">
                                        {{ csrf_field() }}
                                        <input type="text" name="url" value="">
                                        <input type='submit' id="submit" class="btn btn-primary submit" value="Edit">
                                    </form>
                                </td>
                                <td><a href="{{ action('User\SiteController@edit', [$site->id]) }}" class="btn btn-primary">Edit</a>

                                    <a href="{{ action('User\SiteController@delete', [$site->id]) }}" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $sites->links() }}
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