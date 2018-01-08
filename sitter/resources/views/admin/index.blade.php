@extends('layouts.appAdmin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if(Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}          
            </div>
            @endif
            @if(Session::has('successfully'))
            <div class="alert alert-success">
                {{ Session::get('successfully') }}          
            </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">Admin panel</div>
                <div class="panel-body">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection