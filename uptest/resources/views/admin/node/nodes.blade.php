@extends('admin.layouts.admin')

@section('content')
    <div class="col-md-10">
        <a href="{{url('admin/node/create')}}"
           id="add-new" class="btn btn-primary">
            Добавить ноду
        </a>

        <table class="table table-striped">
            <thead>
            <tr>
                <td>ID</td>
                <td>NAME</td>
                <td>IP:PORT</td>
                <td>COUNTRY</td>
                <td>FLAG</td>
                <td>STATUS</td>
                <td colspan="4">OPERATION</td>
            </tr>
            </thead>

            @foreach ($nodes as $node)

                <tr>
                    <td><a href="{{ url('/admin/node/'.$node->id) }}">{{ $node->id }}</a></td>
                    <td>{{ $node->name }}</td>
                    <td>{{ $node->ip }}:{{ $node->port }}</td>
                    <td>{{ $node->country }}</td>
                    <td>{{ $node->flag }}</td>
                    <td>{{ $node->status }}</td>

                    <td>
                        <a href="{{ url('/admin/node/'.$node->id) }}"><i class="fa fa-share"></i>edit</a>

                        <a class="warning" href="{{ url('/admin/node/status/'.$node->id) }}">
                            <i class="fa fa-microphone-slash"></i>
                            {{ $node->status }}
                        </a>
                    </td>

                </tr>
            @endforeach
        </table>
        {!!$nodes->render()!!}
    </div>


@endsection