@extends('admin.layouts.admin')

@section('content')
    <div class="col-md-10">
        <table class="table table-striped">
            <thead>
            <tr>
                <td>ID</td>
                <td>Url</td>
                <td>Type</td>
                <td>Types load res</td>
                <td>Intensity</td>
                <td>Intensity step</td>
                <td>Intensity max</td>
                <td>Status</td>

                <td colspan="4">OPERATION</td>
            </tr>
            </thead>
            @foreach ($tasks as $task)

                <tr>
                    <td><a href="{{ url('/admin/task/'.$task->id) }}">{{ $task->id  }}</a></td>
                    <td>{{ $task->main_url  }}</td>

                    <td>{{ $task->type  }}</td>
                    <td>
                        {{ $task->css ? "css "  : "" }}
                        {{ $task->js ? "js "  : "" }}
                        {{ $task->img ? "img "  : "" }}
                    </td>
                    <td>{{ $task->intensity  }}</td>
                    <td>{{ $task->intensity_step  }}</td>
                    <td>{{ $task->intensity_max  }}</td>
                    <td>{{ $task->status  }}</td>


                    <td><a href="{{ url('/admin/task/'.$task->id) }}">detail</a></td>
                    <td><a href="{{ url('/admin/task/reset/'.$task->id) }}">reset</a></td>
                    <td><a href="{{ url('/admin/task/delete/'.$task->id) }}">delete</a></td>


                </tr>
            @endforeach
        </table>
        {!!$tasks->render()!!}
    </div>


@endsection