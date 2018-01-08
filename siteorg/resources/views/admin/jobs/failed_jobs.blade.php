@extends('layouts.app_admin')

@section('css')
    @include('layouts._block.media')
@endsection

@section('breadcrumb')
    <li><a href="{{ action('Admin\AdminController@index') }}">Home</a></li>
    <li class="active">Failed Jobs</li>
@endsection

@section('content')
    <div class="container">
        <div class="row">

            @include('layouts._block.session_message');

            @include('admin.jobs._menu');

            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-3"><h4>Failed Jobs</h4></div>
                        <div class="col-md-2 col-md-offset-6">
                            <a href="{{ action('Admin\AdminController@retryAll') }}" class="btn btn-primary">Retry All</a>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <tr>
                            <th>id</th>
                            <th>Exception</th>
                            <th>Action</th>
                        </tr>
                        @if(count($failed_jobs))
                            @foreach($failed_jobs as $job)
                                <tr>
                                    <td>{{ $job->id }}</td>
                                    <td>
                                        <span class="read block">{{ $job->exception }}
                                        </span>
                                    </td>
                                    <td><a href="{{ action('Admin\AdminController@retry', $job->id) }}" class="btn btn-default">Retry</a></td>
                                </tr>
                            @endforeach
                        @else
                            <tr style="text-align: center">
                                <td colspan="2">Null</td>
                            </tr>
                        @endif

                    </table>
                    {{ $failed_jobs->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
@section('javascript')
    <script src="{{ asset('js/readmore.min.js') }}"></script>
    <script>
        $('.read').readmore({
            afterToggle: function(trigger, element, more) {
                if(! more) {
                    $('html, body').animate({
                        scrollTop: element.offset().top
                    },{
                        duration: 100
                    });
                }
            }
        });
    </script>

@endsection