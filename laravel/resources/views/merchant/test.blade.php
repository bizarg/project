@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                @include('errors._sessionBlock')

                <div class="panel panel-default">
                    <div class="panel-heading">rhtxjyjxtjty</div>
                    <div class="panel-body">
                        <form method="POST" action="{{ action('WebMoneyController@result') }}">
                            {{--<input type="hidden" name="LMI_PREREQUEST" value="1">--}}
                            {{--<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="1.0">--}}
                            {{--<input type="hidden" name="LMI_PAYMENT_NO" value="1">--}}
                            {{--<input type="hidden" name="LMI_PAYEE_PURSE" value="U306317924746">--}}
                            {{--<input type="hidden" name="LMI_MODE" value="1">--}}
                            {{--<input type="hidden" name="LMI_PAYER_WM" value="111122221111">--}}
                            {{--<input type="hidden" name="LMI_PAYER_PURSE" value="R111122221111">--}}
                            {{--<input type="hidden" name="FIELD_1" value="VALUE_1">--}}
                            {{--<input type="hidden" name="FIELD_2" value="VALUE_2">--}}


                                <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="1.0">
                                <input type="hidden" name="LMI_PAYMENT_NO" value="1">
                                <input type="hidden" name="LMI_PAYEE_PURSE" value="U306317924746">
                                <input type="hidden" name="LMI_MODE" value="1">
                                <input type="hidden" name="LMI_SYS_INVS_NO" value="281">
                                <input type="hidden" name="LMI_SYS_TRANS_NO" value="558">
                                <input type="hidden" name="LMI_PAYER_PURSE" value="R397000000473">
                                <input type="hidden" name="LMI_PAYER_WM" value="809000000852">
                                <input type="hidden" name="LMI_SYS_TRANS_DATE" value="20020314 14:01:14">
                                <input type="hidden" name="LMI_HASH" value="114128B8AEFD8CAA76D3CF75B9AEBC17">
                                <input type="hidden" name="LMI_HASH2" value="8ACAC8C59D6CA6EB0AD56DF5C0CE8BB4D096557C8AF0C642D7E5CE1344C107D8">
                                <input type="hidden" name="FIELD_1" value="VALUE_1">
                                <input type="hidden" name="FIELD_2" value="VALUE_2">

                            <input type="submit" class="wmbtn" style="font-famaly:Verdana, Helvetica, sans-serif!important;padding:0 10px;height:30px;font-size:12px!important;border:1px solid #538ec1!important;background:#a4cef4!important;color:#fff!important;" value="Оплатить">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection