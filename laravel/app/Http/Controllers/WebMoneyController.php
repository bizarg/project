<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class WebMoneyController extends Controller
{

    public function index()
    {
        return view('merchant.form');

    }

    public function test()
    {
        return view('merchant.test');
    }

    public function result(Request $request)
    {
        if($request->get('LMI_PREREQUEST') == 1) {
            if ($request->get('LMI_PAYEE_PURSE') != 'U306317924746') {
                return false;
            }
            echo 'YES';
        } else {

//            return 'NO';
//            $orderDate = time();
//            $user = Auth::user();
//
//            $order =  Order::create([
//                'orderReference' => '№' . $orderDate,
//                'amount' => $request->get('LMI_PAYMENT_AMOUNT'),
//                'orderDate' => $orderDate,
//                'status' => 0,
//                'user_id' => $user->id
//            ]);
////            $key = $this->getSignature($request);
////
////            if($key != $request->get('LMI_HASH')) return false;
        }
    }

    public function access(){
        return redirect('merchant/form')->with('successfully', 'платеж прошел успешно');
    }

    public function fail(){
        return redirect('merchant/form')->with('error', 'платеж не прошел');
    }

    public function getSignature($request)
    {
        $hashStr =
            $request->get('LMI_PAYEE_PURSE').
            $request->get('LMI_PAYMENT_AMOUNT').
            $request->get('LMI_PAYMENT_NO').
            $request->get('LMI_MODE').
            $request->get('LMI_SYS_INVS_NO').
            $request->get('LMI_SYS_TRANS_NO').
            $request->get('LMI_SYS_TRANS_DATE').
            '123456789'.
            $request->get('LMI_PAYER_PURSE').
            $request->get('LMI_PAYER_WM');

        return strtoupper(hash('sha256', $hashStr));
    }
}
