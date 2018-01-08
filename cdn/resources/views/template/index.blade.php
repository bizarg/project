@extends('layouts.panel')

@section('breadcrumb')
    <li><a href="/">Home</a></li>
    <li class="active">Templates</li>
@endsection

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">x</span></button>
            <h4>Success!</h4>
            <p>{{session('success')}}</p>
        </div>
    @elseif (session('fail') or !$errors->isEmpty())
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">x</span></button>
            <h4>Error!</h4>
            <p>{{session('fail')}}</p>
        </div>
    @endif

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-3"><h4>Templates</h4></div>
                <div class="col-md-2 col-md-offset-6">
                    <a href="{{ route('templates.create') }}" class="btn btn-default">Create Template</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <tr>
                    <th>Code</th>
                    <th>Action</th>
                </tr>
                @if(count($templates))
                @foreach($templates as $template)
                    <tr>
                        <td>{{ $template->code }}</td>
                        <td><span class="pull-right">


                            @if($template->active)
                            <a href="{{ action('TemplateController@active', [$template->id]) }}" class="btn btn-success">Active</a>
                            @else
                            <a href="{{ action('TemplateController@active', [$template->id]) }}" class="btn btn-warning">Inactive</a>
                            @endif
                            <a href="{{ route('templates.edit', [$template->id]) }}" class="btn btn-default">Edit</a>
                            <a href="#" class="btn btn-danger" onclick="event.preventDefault();document.getElementById('destroy-form{{ $template->id }}').submit();">Delete</a>
                            <form id="{{ 'destroy-form'.$template->id }}" action="{{ route('templates.destroy', $template->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            </form>
                            </span>
                        </td>
                    </tr>
                @endforeach
                @else
                    <tr style="text-align: center">
                        <td colspan="2">Нет Шаблонов</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection


