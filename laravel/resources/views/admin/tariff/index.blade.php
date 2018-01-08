@extends('layouts.appAdmin')

@section('breadcrumb')
    <li><a href="{{ action('Admin\AdminController@index') }}">Admin</a></li>
    <li class="active">Tariffs</li>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                @include('errors._sessionBlock')

                <div class="panel panel-default">
                    <div class="panel-heading">New Tariff</div>
                    <div class="panel-body">
                        <form action="{{ action('Admin\TariffController@store') }}" method="post" class="form-horizontal">
                            {{ csrf_field() }}
                            @include('_form._input', ['name' => 'name', 'model' => 'tariff'])

                            @include('_form._input', ['name' => 'value', 'model' => 'tariff'])

                            @include('_form._button', ['buttonName' => 'Create'])

                        </form>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Tariffs</div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <tr>
                                <th>Name</th>
                                <th>Value</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            @if(count($tariffs))
                                @foreach($tariffs as $tariff)
                                    <tr>
                                        <td>{{ $tariff->name }}</a></td>
                                        <td>{{ $tariff->value }}</td>
                                        <td style="width: 20px;"><a href="{{ action('Admin\TariffController@edit', [$tariff->id]) }}" class="btn btn-primary">Edit</a></td>
                                        <td style="width: 20px;"><a href="{{ action('Admin\TariffController@destroy', [$tariff->id]) }}" class="btn btn-danger">Delete</a></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">No domains</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection