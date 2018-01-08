@extends('layouts.admin')

@section('content')

    @include('layouts._layout.header_menu')

    <div class="row tab-container">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form name="task" method="POST" action="{{ url('/task/new') }}">
                        {!! csrf_field() !!}

                        <div class='row'>
                            <div class="col-md-12">
                                <label for="domain input">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    Адрес сайта для запросов (домен обязательно)</label>

                                <div class="form-group">
                                    {{--<select id="task_type" required name="domain"--}}
                                    {{--class="btn btn-default form-select">--}}
                                    {{--<option value="" disabled selected>-- выберите тип теста --</option>--}}
                                    {{--@foreach($domains as $domain)--}}
                                    {{--<option value="{{ $domain->id }}">{{ $domain->domain }}</option>--}}
                                    {{--@endforeach--}}
                                    {{--</select>--}}
                                    <input maxlength="2048"
                                           class="form-control"
                                           type="text"
                                           name="query"
                                           value="{{ old() ? old('query') : ($active_domain ? 'http://'.$active_domain->domain.'/' : '')}}"
                                           placeholder="http://domain.com/query/sring?param1=value1&paramN=valueN"/>
                                </div>
                                <label>
                                    @if ($errors->has('query'))
                                        <small class="text-danger">
                                            <strong>{{ $errors->first('query') }}</strong>
                                            <br>
                                        </small>
                                    @endif
                                </label>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="domain input">
                                        <i class="fa fa-asterisk text-danger"></i>
                                        Тип теста
                                    </label>
                                    <span class="input-group-btn">
                                          <select id="task_type" required name="type"
                                                  class="btn btn-default form-select">
                                              {{--<option value="" disabled selected>-- выберите тип теста --</option>--}}
                                              @foreach($types as $type)
                                                  <option value="{{ $type }}" {{ old('type')  == $type ? 'selected' : "" }}>{{ $type }}</option>
                                              @endforeach
                                          </select>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><i class="fa fa-asterisk text-danger"></i>
                                        Интенсивность запросов в минуту
                                    </label>
                                    <input type="text"
                                           name="intensity"
                                           class="form-control"
                                           required
                                           placeholder="от 10 до 1000"
                                           @if( Auth::check() &&  Auth::user()->role != 'admin')
                                           pattern="[0-9]{2,4}"
                                           @endif
                                           value="{{ old('intensity') }}"
                                            />
                                    <label>
                                        @if ($errors->has('intensity'))
                                            <small class="text-danger">
                                                <strong>{{ $errors->first('intensity') }}</strong>
                                                <br>
                                            </small>
                                        @endif
                                    </label>

                                    <div id="block-period">
                                        <label><i class="fa fa-asterisk text-danger"></i>
                                            Время тестированния в секундах
                                        </label>
                                        <span class="input-group-btn">
                                            <select id="work_time" required name="work_time"
                                                    class="btn btn-default form-select">
                                                @foreach($periods as $period)
                                                    <option value="{{ $period }}" {{ old('work_time')  == $period ? 'selected' : "" }}>{{ $period }}</option>
                                                @endforeach
                                            </select>
                                        </span>
                                        <label>
                                            @if ($errors->has('work_time'))
                                                <small class="text-danger">
                                                    <strong>{{ $errors->first('work_time') }}</strong>
                                                    <br>
                                                </small>
                                            @endif
                                        </label>
                                    </div>


                                    <div id="block-intensity">
                                        <label><i class="fa fa-asterisk text-danger"></i>
                                            Приращение интенсивности запросов в минуту
                                        </label>
                                        <input id="intensity_step" type="text"
                                               name="intensity_step"
                                               class="form-control"
                                               placeholder="от 10 до 100"
                                               @if( Auth::check() &&  Auth::user()->role != 'admin')
                                               pattern="[0-9]{2,3}"
                                               @endif
                                               value="{{ old('intensity_step') }}"
                                                />
                                        <label>
                                            @if ($errors->has('intensity_step'))
                                                <small class="text-danger">
                                                    <strong>{{ $errors->first('intensity_step') }}</strong>
                                                    <br>
                                                </small>
                                            @endif
                                        </label>
                                    </div>

                                    <div id="block-wait">
                                        <label><i class="fa fa-asterisk text-danger"></i>
                                            Время ожидания между итерациями в секундах
                                        </label>
                                        <span class="input-group-btn">
                                            <select id="wait_time" required name="wait_time"
                                                    class="btn btn-default form-select"
                                                    >
                                                @foreach($wtimes as $wtime)
                                                    <option value="{{ $wtime }}" {{ old('wait_time')  == $wtime ? 'selected' : "" }}>{{ $wtime }}</option>
                                                @endforeach
                                            </select>
                                        </span>
                                        <label>
                                            @if ($errors->has('wait_time'))
                                                <small class="text-danger">
                                                    <strong>{{ $errors->first('wait_time') }}</strong>
                                                    <br>
                                                </small>
                                            @endif
                                        </label>
                                    </div>


                                </div>

                                <div class="form-group">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Дополнительные параметры</label>

                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="css" value="1"
                                                    {{ old() ? old('css', 1) ? 'checked="checked"' : '' : 'checked="checked"' }} >
                                            Загружать CSS файлы.
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="js" value="1"
                                                    {{ old() ? old('js', 1) ? 'checked="checked"' : '' : 'checked="checked"' }} >
                                            Загружать JavaScript файлы.
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="img" value="1"
                                                    {{ old() ? old('img') ? 'checked="checked"' : '' : 'checked="checked"' }} >
                                            Загружать изображения.
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4">
                                {{-- <label>Параметры для POST запроса</label>

                                 <div class="checkbox">
                                     <label>
                                         <input type="checkbox"/>
                                         Не использовать POST запрос
                                     </label>
                                 </div>
                                 <textarea
                                         name="postData"
                                         class="form-control"
                                         maxlength="2048"
                                         placeholder="param1=value1&param2=value2&etc=etc">
                                 </textarea>
                                 <label>
                                     @if ($errors->has('postData'))
                                         <small class="text-danger">
                                             <strong>{{ $errors->first('postData') }}</strong>
                                             <br>
                                         </small>
                                     @endif
                                 </label>--}}
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success">
                                    Добавить задачу
                                </button>
                                <span class="text-danger">
                                    &nbsp;&nbsp; <i class="fa fa-asterisk"></i>
                                    <span class="text-primary">- Поля помеченые звёздочкой обязательны для заполнения.</span>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            settype();


            $("#task_type").change(function () {
                settype();
            });
        });

        function settype() {
            var value = $("#task_type option:selected").val();
            if (value === 'static') {
                $("#intensity_step").prop("disabled", true);
                $("#wait_time").prop("disabled", true);
//                $("#work_time").prop("disabled", false);


            } else {
                $("#intensity_step").prop("disabled", false);
                $("#wait_time").prop("disabled", false);
//                $("#work_time").prop("disabled", true);
            }
        }
    </script>
@endsection