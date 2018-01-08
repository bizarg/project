@extends('layouts.admin')

@section('content')

    @include('layouts._layout.header_menu')

    <div class="row tab-container" ng-controller="DomainController as DC">
        <div class="col-md-12">
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
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-2">Пополнить баланс</div>
                        <div class="col-md-2 col-md-offset-7"><strong>Баланс</strong>: {{ Auth::user()->balance }} <small>points</small></div>
                    </div>
                </div>
                <div class="panel-body">
                    <form action="https://merchant.webmoney.ru/lmi/payment.asp" method="POST">
                        <div class="form-group col-md-2">
                            <input type="text" name="LMI_PAYMENT_AMOUNT" value="" class="form-control">
                        </div>
                        <input type="hidden" name="LMI_PAYMENT_DESC_BASE64" value="0YLQtdGB0YLQvtCy0YvQuSDRgtC+0LLQsNGA">
                        <input type="hidden" name="LMI_PAYEE_PURSE" value="{{ config('webmoney.WM_LMI_PAYEE_PURSE') }}">
                        <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                        <input type="submit" class="btn btn-primary" value="Пополнить">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection