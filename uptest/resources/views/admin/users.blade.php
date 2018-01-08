@extends('admin.layouts.admin')

@section('content')
    <div class="col-md-10">
        <table class="table table-striped">
            <thead>
            <tr>
                <td>ID</td>
                <td>EMAIL</td>
                <td>Domains</td>
                <td>STATUS</td>
                <td>CREATED</td>
                <td colspan="4">OPERATION</td>
            </tr>
            </thead>

            @foreach ($users as $user)

                <tr>
                    <td><a href="{{ url('/admin/user/detail/'.$user->id) }}">{{ $user->id  }}</a></td>
                    <td>{{ $user->email  }}</td>
                    <td>{{ $user->domains  }}</td>
                    <td>{{ $user->status  }}</td>
                    <td>{{ $user->created_at  }}</td>
                    <td><a href="{{ url('/admin/user/detail/'.$user->id) }}">detail</a></td>
                    <td><a href="{{ url('/admin/user/profile/'.$user->id) }}"><i class="fa fa-share"></i>edit</a></td>

                    <td>
                        <a class="warning" href="{{ url('/admin/user/suspend/'.$user->id) }}"><i class="fa fa-microphone-slash"></i>
                            @if ($user->status == 'active')
                                suspend
                            @else
                                unsuspend
                            @endif
                        </a>
                    </td>

                </tr>
            @endforeach
        </table>
        {!!$users->render()!!}
    </div>


@endsection