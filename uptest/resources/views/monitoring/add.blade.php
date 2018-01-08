@extends('layouts.admin')

@section('content')

    @include('monitoring.header_menu')

    <div class="row tab-container">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    <form name="task" method="POST" action="{{ url('/monitoring/add') }}">
                        {!! csrf_field() !!}

                        <div class='row'>
                            <div class="col-md-12">
                                <label for="domain input">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    Адресс сайта для мониторинга
                                </label>

                                <div class="form-group">

                                    <input maxlength="1024"
                                           class="form-control"
                                           type="text"
                                           name="url"
                                           value="{{ old('url') }}"
                                           placeholder="http://domain.com/"/>
                                </div>

                                @if ($errors->has('url'))
                                    <label>
                                        <small class="text-danger">
                                            <strong>{{ $errors->first('url') }}</strong>
                                            <br>
                                        </small>
                                    </label>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="domain input">
                                        <i class="fa fa-asterisk text-danger"></i>
                                        Страна мониторинга
                                    </label>
                                    <span class="input-group-btn">
                                          <select id="node_id" required name="node_id"
                                                  class="btn btn-default form-select">
                                              @foreach($nodes as $node)
                                                  <option value="{{ $node->id }}" {{ old('node_id') == $node->id ? 'selected' : "" }}>{{ $node->getNodeName() }}</option>
                                              @endforeach
                                          </select>
                                        @if ($errors->has('node_id'))
                                            <label>
                                                <small class="text-danger">
                                                    <strong>{{ $errors->first('node_id') }}</strong>
                                                    <br>
                                                </small>
                                            </label>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success">
                                    Добавить на мониторинг
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


@endsection