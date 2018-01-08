@extends('layouts.admin')

@section('content')

    @include('layouts._layout.header_menu')

    <div class="row tab-container" ng-controller="DomainController as DC">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form name="domainForm" method="POST" action="{{ url('/domain/add') }}">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label for="domain input">Доменное имя сайта</label>
                            <input type="text"
                                   class="form-control"
                                   name="domain"
                                   placeholder="google.com"
                                   maxlength=253
                                   {{--pattern="/^(?!-)[\w-]{1,53}(\.[\w\.-]{1,63})+$/"--}}
                                   required
                                   autofocus
                                   value="{{ old('domain') }}"
                                    />

                            @if ($errors->has('domain'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('domain') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-default">
                            Добавить домен
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Добавленые домены</div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Статус</th>
                            <th>Домен</th>
                            <th>Дата истечения</th>
                            <th class="text-right">Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($domains as $domain)
                            <tr>
                                <td>{{ $domain->id }}</td>
                                <td>
                                    <span class="label @if ($domain->status == 'confirmed') label-success @else label-danger @endif">{{ $domain->status }}</span>
                                </td>
                                <td>
                                    {{ $domain->domain }}
                                </td>
                                <td>
                                    @if ($domain->status != 'confirmed')
                                        <span>  {{ LocalizedCarbon::instance(new Laravelrus\LocalizedCarbon\LocalizedCarbon($domain->expired) )->diffForHumans() }}</span>
                                    @endif
                                </td>
                                <td class="text-right" id="confirmBlock{{ $domain->id }}">
                                    @if ($domain->status != 'confirmed')
                                        <div class="btn-group">
                                            <a onclick="return confirm('Вы точно хотите удалить ?')"
                                               class="btn btn-danger btn-sm"
                                               href="{{ url('/domain/delete/'.$domain->id) }}">Удалить</a>
                                            <button class="btn btn-default btn-sm" id="confirmButton{{ $domain->id }}"
                                                    onclick="confirm({{ $domain->id }})">
                                                Подтвердить
                                            </button>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle btn-sm"
                                                        data-toggle="dropdown">
                                                    Способ
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li data-target="#keyVerifying{{ $domain->id }}"
                                                        data-toggle="modal"><a
                                                                href="#">Ключем</a></li>
                                                    <li ng-if="dom.status == 0"
                                                        data-target="#metaVerifying{{ $domain->id }}"
                                                        data-toggle="modal"><a href="#">Метатегом</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    @else
                                        <a href="{{ url('/task/new/'.$domain->id) }}" class="btn btn-success btn-sm">Добавить задание</a>
                                        <a href="{{ url('/domain/token/update/'.$domain->id) }}"
                                           class="btn btn-warning btn-sm">Обновить ключ</a>
                                        <a href="{{ url('/domain/delete/'.$domain->id) }}"
                                           class="btn btn-danger btn-sm">Удалить</a>
                                        @endif
                                                <!-- Modal Meta Verifying -->
                                        <div class="modal fade text-left" id="metaVerifying{{ $domain->id }}"
                                             tabindex="-1" role="dialog"
                                             aria-labelledby="myModalLabel"
                                             aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close"
                                                                data-dismiss="modal"
                                                                aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title" id="myModalLabel">
                                                            Подтверждение сайта метатегом
                                                        </h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>1. Добавьте в код главной страницы вашего сайта (в раздел
                                                            head) мета-тэг
                                                        </p>

                                                        <p><code>&lt;meta name='loadservice-verification'
                                                                content='{{ $domain->token }}'&gt;</code></p>

                                                        <p>2. Зайдите на главную страницу сайта и убедитесь, что
                                                            мета-тэг
                                                            появился в html-коде страницы. В большинстве браузеров это
                                                            можно
                                                            сделать выбрав пункт "Исходный код страницы" в контекстном
                                                            меню. На
                                                            некоторых сайтах обновление мета-тэгов может занимать
                                                            несколько
                                                            минут!</p>

                                                        <p>3. Нажмите на кнопку «Подтвердить»</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">
                                                            Закрыть
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--EndModal-->
                                        <!-- Modal Key Verifying -->
                                        <div class="modal fade text-left" id="keyVerifying{{ $domain->id }}"
                                             tabindex="-1"
                                             role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title" id="myModalLabel">Подтверждение сайта
                                                            ключем</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>1. Для подтверждения доменного имени {{ $domain->domain }},
                                                            Вы
                                                            должны
                                                            создать в корневом каталоге домена файл:
                                                            <br><code>{{ $domain->token }}.txt</code></p>

                                                        <p>2. Сcылка по которой должен быть доступен файл: <br><a
                                                                    href="http://{{ $domain->domain }}/{{ $domain->token }}.txt"
                                                                    target="_blank">http://{{ $domain->domain }}
                                                                /{{ $domain->token }}.txt</a></p>

                                                        <p>3. Нажмите на кнопку «Подтвердить»</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">
                                                            Закрыть
                                                        </button>
                                                        <a type="button" class="btn btn-primary"
                                                           href="{{ url('domain/token/'.$domain->id) }}">Скачать ключ
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--EndModal-->

                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function confirm(id) {
            $('#confirmButton' + id).html('Проверка..');
            $('#confirmButton' + id).attr("disabled", true);
            $.ajax({
                url: "{{ url('/domain/confirm/') }}/" + id,

            }).done(function (data) {
                console.log(data);
                if (data.toString() == 'confirmed') {
                    location.reload();
                } else {
                    // $('#confirmBlock' + id).prepend(data);
                    $('#confirmButton' + id).html('Подтвердить');
                    $('#confirmButton' + id).removeAttr("disabled");
                }
            });
        }
    </script>
@endsection