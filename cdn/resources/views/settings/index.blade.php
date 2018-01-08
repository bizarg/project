@extends('layouts.panel')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Home</a></li>
    <li class="breadcrumb-item active">Domains</li>
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading"><b>Domains</b></div>
        <div class="panel-body">
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    <h4>Success!</h4>
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
                        <th>Domain</th>
                        <th>Link Format</th>
                        <th>Short Name</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody id="upload_files">
                        @forelse($domains as $domain)
                            <tr>
                                <td><b>{{$domain->domain}}</b></td>
                                <td><b>{{$domain->link_format}}</b></td>
                                <td><b>{{$domain->shortname}}</b></td>
                                <td>
                                    <form action="{{route('settings.destroy', $domain->id)}}" method="POST">
                                        {{csrf_field()}}
                                        {{method_field('DELETE')}}
                                        <a href="{{route('settings.edit', $domain->id)}}"><span class="glyphicon glyphicon-edit text-info" aria-hidden="true"></span></a>
                                        <a href="#!"><span class="glyphicon glyphicon-remove text-danger" aria-hidden="true" data-target="delete"></span></a>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">You haven't ftp accounts. <a href="{{route('settings.create')}}">Add account</a></td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
            <a href="{{route('settings.create')}}" class="btn btn-primary pull-right">Add new</a>
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
            if (!confirm('Are you sure?\nThis operation deleted this domain!')) {
                e.preventDefault();
            } else {
                var form = obj.parents('form:first');
                form.submit();
            }
        }
    </script>
@endsection