<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Payment\CreatePayment;
use App\Http\Payment\ResponsePayment;
use Auth;
use App\Order;

use App\Domain;
use App\User;
use Mail;

class WayForPayController extends Controller
{
//    public function test()
//    {
//
//    }

    public function test()
    {


        $domains = Domain::where('status_id', 2)->with('user', 'tariff')->get();

        foreach($domains as $domain){
            dump($domain->user->balance);
            if($domain->begin_at < time()) {
                $user = $domain->user;
                $tariff = $domain->tariff;
                if($user->balance > $tariff->value){
                    $user->update(['balance' => $user->balance -= $tariff->value]);

                    $domain->update(['begin_at' => time() + 10]);

                    Mail::queue('emails.payed',
                        array('name' => $domain->name,
                            'tariff' => $tariff,
                            'date' => $domain->begin_at)
                        , function ($message) use ($user){
                            $message->to($user->email)->subject('Payed');}
                    );
                }
            }
            dump($domain->user->balance);

        }
    }

//    public function curl()
//    {
//        $arr = [
//            "merchantAccount" => "test_merch_n1",
//            "orderReference" => "ref_1492525413",
//            "merchantSignature" => "",
//            "amount" => "1",
//            "currency" => "UAH",
//            "authCode" => "541963",
//            "email" => "client@mail.ua",
//            "createdDate" => "1492525413",
//            "processingDate" => "",
//            "cardPan" => "4102****8217",
//            "cardType" => "visa",
//            "issuerBankCountry" => "980",
//            "issuerBankName" => "Privatbank",
//            "recToken" => "",
//            "transactionStatus" => "Approved",
//            "reason" => "1100",
//            "reasonCode" => "",
//            "fee" => "",
//            "paymentSystem" => "card"
//        ];
//
//        $data = json_encode($arr);
//
//        $ch = curl_init('http://laravel.loc/service');
//
//
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
//        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//
//        $res = curl_exec($ch);
//        echo $res;
//
//        if(curl_exec($ch) === false)
//        {
//            return 'Ошибка curl: ' . curl_error($ch);
//        }
//        curl_close($ch);
//
//    }
}
