@extends('layouts.appAdmin')

@section('breadcrumb')
    <li><a href="{{ action('Admin\AdminController@index') }}">Admin</a></li>
    <li><a href="{{ route('tariff.index') }}">Tariffs</a></li>
    <li class="active">Edit Tariff</li>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                @include('errors._sessionBlock')

                <div class="panel panel-default">
                    <div class="panel-heading">Edit</div>
                    <div class="panel-body">
                        </br>
                        </br>
                        <form action="{{ action('Admin\TariffController@update', [$tariff->id]) }}" method="post" class="form-horizontal">
                            <input type="hidden" name="_method" value="PATCH">
                            {{ csrf_field() }}
                            @include('_form._input', ['name' => 'name', 'model' => 'tariff'])

                            @include('_form._input', ['name' => 'value', 'model' => 'tariff'])

                            @include('_form._button', ['buttonName' => 'Update'])

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection