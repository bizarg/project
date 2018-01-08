@extends('layouts.admin')

@section('content')

    @include('layouts._layout.header_menu')

    <div class="row tab-container">
        <div class="col-md-12">

            <div class="panel panel-default">
                <form name="domainForm" method="get">


                    <div class="panel-body">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="domain input">Сортировка по типу теста</label>
                                <select class="form-select form-control" name="type" style="background-color:#fff;"
                                        onchange="this.form.submit()">
                                    <option value="">Все тесты</option>
                                    <option value="static">статические</option>
                                    {{--<option value="dynamic">динамические</option>--}}
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="domain input">Сортировка по статусу</label>
                                <select name="status" class="form-select form-control" style="background-color:#fff;"
                                        onchange="this.form.submit()">
                                    <option value="">Все задания</option>
                                    <option value="new">Новые</option>
                                    <option value="inprogress">Обрабатываются</option>
                                    <option value="finished">Завершенные</option>
                                    <option value="error">Ошибка</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="domain input">Поиск</label>
                                <input type="text" name="search"
                                       placeholder="Введите домен, или любой другой параметр для поиска"
                                       class="form-control" autofocus/>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    Задания
                </div>
                <div class="panel-body">
                    {{--   <p>
                           <span class="text-info">Ожидание в очереди @{{JC.jobTimeStart-5}} минут</span>
                       </p>--}}
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>URL</th>
                            <th>Тип</th>

                            <th>Интенсивность</th>
                            <th>Статус</th>
                            <th>Время создания</th>

                            <th class="text-right">Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tasks as $task)
                            <tr>
                                <td>{{ $task->id }}</td>
                                <td>{{ str_limit($task->main_url , 30)}}</td>
                                <td>{{ $task->type }}</td>
                                <td>{{ $task->intensity }}</td>
                                <td>
                                    @if($task->status == 'new')
                                        <span class='text-warning'>Новая</span>
                                    @elseif($task->status == 'inprogress')
                                        <span class='text-info'>Обрабатывается</span>
                                    @elseif($task->status == 'finished')
                                        <span class='text-success'>Обработан</span>
                                    @elseif($task->status == 'error')
                                        <span class="text-danger">Ошибка</span>
                                    @endif

                                </td>
                                <td>
                                    {{ $task->created_at }}
                                </td>
                                <td class="text-right">
                                    <a href="{{ url("/task/".$task->id) }}"
                                       class="btn btn-sm btn-primary">
                                        Подробно
                                    </a>
                                    @if($task->status == 'new')
                                        <a href="{{ url("/task/start/".$task->id) }}"
                                           class="btn btn-sm btn-primary">
                                            Старт
                                        </a>
                                    @endif
                                    @if($task->status == 'finished')
                                        <a href="{{ url("/task/load/".$task->id) }}"
                                           class="btn btn-sm btn-primary">
                                            Load Report
                                        </a>
                                    @endif
                                    {{--<button   class="btn btn-sm btn-danger"
                                            ng-disabled="job.status =='disabled' ||job.status == 'canceled' || job.status == 'completed'">
                                        Отменить
                                    </button>--}}
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    {!!$tasks->render()!!}
                </div>
            </div>
        </div>
    </div>
@endsection