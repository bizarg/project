@extends('admin.layouts.admin')

@section('content')
    <div class="col-md-10">
        <a href="{{url('admin/site/create')}}"
           id="add-new" class="btn btn-primary">
            Добавить сайт
        </a>

        <table class="table table-striped">
            <thead>
            <tr>
                <td>ID</td>
                <td>URL</td>
                <td>USER</td>
                <td>NODE</td>
                <td>STATUS</td>
                <td colspan="4">OPERATION</td>
            </tr>
            </thead>

            @foreach ($sites as $site)

                <tr>
                    <td><a href="{{ url('/admin/site/'.$site->id) }}">{{ $site->id }}</a></td>
                    <td>{{ $site->url }}</td>
                    <td>{{ $site->user->name }}</td>
                    <td><a href="{{ url('admin/node',[$site->node->id]) }}">{{ $site->node->country }}</a></td>
                    <td>{{ $site->status }}</td>

                    <td>
                        <a href="{{ url('/admin/site/'.$site->id) }}"><i class="fa fa-share"></i>edit</a>

                        <a class="warning" href="{{ url('/admin/site/status/'.$site->id) }}">
                            <i class="fa fa-microphone-slash"></i>
                            {{ $site->status }}
                        </a>
                    </td>

                </tr>
            @endforeach
        </table>
        {!!$sites->render()!!}
    </div>


@endsection