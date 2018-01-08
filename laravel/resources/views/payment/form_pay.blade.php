@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                @include('errors._sessionBlock')

                <div class="panel panel-default">
                    <div class="panel-heading">Pay</div>
                    <div class="panel-body">
                        {!! $form->getButtonPayment('Pay', ['class'=>'paymentOrder', 'id'=>'btnPayment']) !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection