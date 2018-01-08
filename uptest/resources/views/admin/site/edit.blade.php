@extends('admin.layouts.admin')

@section('content')

    <div class="col-md-10">


        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">{{ $error }}</div>
        @endforeach


        @if( isset( $site ) )
            {{ Form::model($site, ['url' => 'admin/site', 'method'=>'POST', 'files'=>true,  'class'=>'form-horizontal'] ) }}
            {{ Form::hidden('id', null, array('class'=>'form-control','required'=>'required') ) }}
        @else
            {!! Form::open(['url' => 'admin/site', 'method'=>'POST', 'files'=>true,  'class'=>'form-horizontal']) !!}
        @endif


        <div class="form-group">
            {{ Form::label('url', 'URL', ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-8">
                {{ Form::text('url', null, ['placeholder'=>'url','class'=>'form-control','required'=>'required'] ) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('user_id', 'Юзер', ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-8">
                {{ Form::select('user_id', $users, null , ['class'=>'btn btn-default form-select','required'=>'required']  )  }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('node_id', 'Страна', ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-8">
                {{ Form::select('node_id', $nodes, null , ['class'=>'btn btn-default form-select','required'=>'required']  )  }}
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