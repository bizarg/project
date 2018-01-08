@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                @include('errors._sessionBlock')

                <div class="panel panel-default">
                    <div class="panel-heading">Pay</div>
                    <div class="panel-body">
                        <form action="https://merchant.webmoney.ru/lmi/payment.asp" method="POST">
                            <input type="text" name="LMI_PAYMENT_AMOUNT" value="" placeholder="0.00">
                            <input type="hidden" name="LMI_PAYMENT_DESC_BASE64" value="0YLQtdGB0YLQvtCy0YvQuSDRgtC+0LLQsNGA">
                            <input type="hidden" name="LMI_PAYEE_PURSE" value="U306317924746">
                            {{--<input type="hidden" name="LMI_PAYMENT_NO" value="{{ time() }}">--}}
                            <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                            <input type="submit" class="wmbtn" style="font-famaly:Verdana, Helvetica, sans-serif!important;padding:0 10px;height:30px;font-size:12px!important;border:1px solid #538ec1!important;background:#a4cef4!important;color:#fff!important;" value="Оплатить">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection