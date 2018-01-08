@extends('admin.layouts.admin')

@section('content')

    <div class="col-md-10">


        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">{{ $error }}</div>
        @endforeach


        @if( isset( $node ) )
            {{ Form::model($node, ['url' => 'admin/node', 'method'=>'POST', 'files'=>true,  'class'=>'form-horizontal'] ) }}
            {{ Form::hidden('id', null, array('class'=>'form-control','required'=>'required') ) }}
        @else
            {!! Form::open(['url' => 'admin/node', 'method'=>'POST', 'files'=>true,  'class'=>'form-horizontal']) !!}
        @endif


        <div class="form-group">
            {{ Form::label('name', 'Имя сервера', ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-8">
                {{ Form::text('name', null, ['placeholder'=>'Имя сервера','class'=>'form-control','required'=>'required'] ) }}
            </div>
        </div>


        <div class="form-group">
            {{ Form::label('ip', 'IP сервера', ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-8">
                {{ Form::text('ip', null, ['placeholder'=>'0.0.0.0','class'=>'form-control','required'=>'required'] ) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('port', 'Port сервера', ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-8">
                {{ Form::text('port', null, ['placeholder'=>'8585','class'=>'form-control','required'=>'required'] ) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('country', 'Страна', ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-8">
                {{ Form::text('country', null, ['placeholder'=>'USA','class'=>'form-control','required'=>'required'] ) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('flag', 'Флаг страны', ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-8">
                {{ Form::text('flag', null, ['placeholder'=>'US','class'=>'form-control','required'=>'required'] ) }}
            </div>
        </div>


        <div class="form-group">
            {{ Form::label('status', 'Статус', ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-8">
                {{ Form::select('status', ['active' => 'active', 'inactive' => 'inactive'], isset( $node ) ? $node->status : 'active' , ['class'=>'btn btn-default form-select','required'=>'required']  )  }}
            </div>
        </div>


        {{ Form::submit('Создать', array('class'=>'btn btn-primary')) }}

        {!! Form::close() !!}

    </div>

@endsection