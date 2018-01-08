@extends('layouts.admin')

@section('content')

    @include('monitoring.header_menu')

    <div class="row tab-container" ng-controller="DomainController as DC">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <a class="btn btn-default"
                       href="{{ url('/monitoring/add') }}">
                        Добавить URL
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Добавленые сайты</div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Домен</th>
                            <th>Урл</th>
                            <th>Статус</th>

                            <th>Дата добавления</th>
                            <th class="text-right">Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($sites as $site)
                            <tr>
                                <td>{{ $site->id }}</td>

                                <td>
                                    {{ $site->domain }}
                                </td>
                                <td>
                                    {{ $site->url }}
                                </td>
                                <td>
                                    {{ $site->status }}
                                </td>
                                <td>
                                    {{ $site->created_at }}
                                </td>
                                <td class="text-right" id="confirmBlock{{ $site->id }}">
                                    <div class="btn-group">
                                        <a onclick="return confirm('Вы точно хотите удалить ?')"
                                           class="btn btn-danger btn-sm"
                                           href="{{ url('/monitoring/delete',[$site->id]) }}">
                                            Удалить
                                        </a>
                                        <a class="btn btn-success btn-sm"
                                           href="{{ url('/monitoring',[$site->id]) }}">
                                            Просмотреть
                                        </a>
                                    </div>

                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection