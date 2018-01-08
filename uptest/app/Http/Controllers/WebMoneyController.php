<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Replanish;

class WebMoneyController extends Controller
{
    public function index()
    {
        return view('service.form');
    }

    public function result(Request $request)
    {
        if($request->LMI_PREREQUEST == 1) {
            if ($request->LMI_PAYEE_PURSE == config('webmoney.WM_LMI_PAYEE_PURSE')){
                return "YES";
            }
            return false;
        } else {
            $key = $this->getSignature($request);

            if($key == $request->LMI_HASH){
                $user = User::find($request->id);
                $user->balance += config('webmoney.price') * $request->LMI_PAYMENT_AMOUNT;
                $user->save();

                Replanish::create([
                    'user_id' => $request->id,
                    'amount' => $request->LMI_PAYMENT_AMOUNT
                ]);
            };
        }
    }

    public function success(){
        return redirect('balance')->with('successfully', 'Платеж прошел успешно');
    }

    public function fail(){
        return redirect('balance')->with('error', 'Платеж не прошел');
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
            config('webmoney.WM_LMI_SECRET_KEY').
            $request->get('LMI_PAYER_PURSE').
            $request->get('LMI_PAYER_WM');

        return strtoupper(hash('sha256', $hashStr));
    }
}
