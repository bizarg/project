@extends('layouts.panel')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Home</a></li>
    <li class="breadcrumb-item active">FTP accounts</li>
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading"><b>FTP accounts</b></div>
        <div class="panel-body">
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    <h4>Saved!</h4>
                    <p>{{session('success')}}</p>
                </div>
            @elseif (Session::has('fail') or !$errors->isEmpty())
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    <h4>Error!</h4>
                    <p>{{session('fail')}}</p>
                </div>
            @endif

            <div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Port</th>
                        <th>Directory</th>
                        <th>login</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody id="upload_files">
                        @forelse($ftps as $acc)
                            <tr>
                                <td><b>{{$acc->name}}</b></td>
                                <td><b>{{$acc->adr}}</b></td>
                                <td><b>{{$acc->port or 'standart'}}</b></td>
                                <td><b>{{$acc->dir or 'root directory'}}</b></td>
                                <td><b>{{$acc->login}}</b></td>
                                <td>
                                    <form action="{{route('ftp-settings.destroy', $acc->id)}}" method="POST">
                                        {{csrf_field()}}
                                        {{method_field('DELETE')}}
                                        <a href="{{route('ftp-settings.edit', $acc->id)}}"><span class="glyphicon glyphicon-edit text-info" aria-hidden="true"></span></a>
                                        <a href="#!"><span class="glyphicon glyphicon-remove text-danger" aria-hidden="true" data-target="delete"></span></a>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">You haven't ftp accounts. <a href="{{route('ftp-settings.create')}}">Add account</a></td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
            <a href="{{route('ftp-settings.create')}}" class="btn btn-primary pull-right">Add new</a>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // click delete icon
        $("span[data-target=delete]").click(function (e) {
            deleteFile(e, $(this));
        });

        function deleteFile(e, obj) {
            if (!confirm('Are you sure?\nThis operation deleted this ftp account!')) {
                e.preventDefault();
            } else {
                var form = obj.parents('form:first');
                form.submit();
            }
        }
    </script>
@endsection