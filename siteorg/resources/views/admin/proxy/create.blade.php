@extends('layouts.app_admin')

@section('breadcrumb')
    <li><a href="{{ action('Admin\AdminController@index') }}">Home</a></li>
    <li><a href="{{ url('admin/proxies') }}">Proxies</a></li>
    <li class="active">Edit</li>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Proxy</div>
                    <div class="panel-body">
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">{{ $error }}</div>
                        @endforeach



                        @if( isset( $proxy ) )
                            {{ Form::model($proxy, ['url' => 'admin/proxies/save', 'method'=>'POST', 'files'=>true,  'class'=>'form-horizontal'] ) }}
                            {{ Form::hidden('id', null, array('class'=>'form-control','required'=>'required') ) }}
                        @else
                            {!! Form::open(['url' => 'admin/proxies/save', 'method'=>'POST', 'files'=>true,  'class'=>'form-horizontal']) !!}
                        @endif

                        <div class="form-group">
                            {{ Form::label('ip', 'IP', ['class' => 'col-sm-2 control-label']) }}
                            <div class="col-sm-8">
                                {{ Form::text('ip', null, ['placeholder'=>'8.8.8.8','class'=>'form-control','required'=>'required'] ) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('port', 'Port', ['class' => 'col-sm-2 control-label']) }}
                            <div class="col-sm-8">
                                {{ Form::text('port', null, ['placeholder'=>'8080','class'=>'form-control','required'=>'required'] ) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('login', 'Login', ['class' => 'col-sm-2 control-label']) }}
                            <div class="col-sm-8">
                                {{ Form::text('login', null, ['placeholder'=>'admin','class'=>'form-control','required'=>'required'] ) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('password', 'Password', ['class' => 'col-sm-2 control-label']) }}
                            <div class="col-sm-8">
                                {{ Form::text('password', null, ['placeholder'=>'234','class'=>'form-control','required'=>'required'] ) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('type', 'Type', ['class' => 'col-sm-2 control-label']) }}
                            <div class="col-sm-8">
                                {{ Form::text('type', null, ['placeholder'=>'google','class'=>'form-control','required'=>'required'] ) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('banned', 'Бан', ['class' => 'col-sm-2 control-label']) }}
                            <div class="col-sm-8">
                                {{ Form::select('banned', ['1' => '1', '0' => '0'], isset( $proxy ) ? $proxy->banned : '0' , ['class'=>'btn btn-default form-select','required'=>'required']  )  }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('status', 'Статус', ['class' => 'col-sm-2 control-label']) }}
                            <div class="col-sm-8">
                                {{ Form::select('status', ['enabled' => 'enabled', 'disabled' => 'disabled'], isset( $proxy ) ? $proxy->status : 'active' , ['class'=>'btn btn-default form-select','required'=>'required']  )  }}
                            </div>
                        </div>


                        <div class="form-group">
                            {{ Form::label('text', 'Текс ответа', ['class' => 'col-sm-2 control-label']) }}
                            <div class="col-sm-8">
                                {{ Form::textarea('text')  }}
                            </div>
                        </div>


                        {{ Form::submit('Сохранить', array('class'=>'btn btn-primary')) }}

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
