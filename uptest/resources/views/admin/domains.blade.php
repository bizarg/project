@extends('admin.layouts.admin')

@section('content')
    <div class="col-md-10">
        <table class="table table-striped">
            <thead>
            <tr>
                <td>ID</td>
                <td>Domain</td>
                <td>Expired</td>
                <td>Status</td>
                 <td colspan="4">OPERATION</td>
            </tr>
            </thead>

            @foreach ($domains as $domain)

                <tr>
                    <td><a href="{{ url('/admin/domain/task/'.$domain->id) }}">{{ $domain->id  }}</a></td>
                    <td>{{ $domain->domain  }}</td>
                    {{--<td>{{ $domain->expired}}</td>--}}
                    <td>{{ $domain->status  !=  'confirmed' ?  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $domain->expired)->diffForHumans()  : '' }}</td>
                    <td>{{ $domain->status  }}</td>
                    <td><a href="{{ url('/admin/domain/task/'.$domain->id) }}">tasks</a></td>


                </tr>
            @endforeach
        </table>
        {!!$domains->render()!!}
    </div>


@endsection