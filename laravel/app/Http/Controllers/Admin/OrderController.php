<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use Auth;
use App\Domain;
use App\Tariff;
use App\Http\Payment\CreatePayment;
use App\User;



class OrderController extends Controller
{
    const PAID = 1;
    const NOT_PAID = 0;

    private $payment;

    public function __construct()
    {
        $this->payment = new CreatePayment();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|max:32|min:2|url|unique:domains,name',
            'tariff' => 'required'
        ]);

        $domain = new Domain ([
            'name' => $request->url,
            'tariff_id' => $request->tariff,
            'user_id' => Auth::user()->id
        ]);

        $amount = Tariff::find($request->tariff);

        if($amount->value) {
            $order = $this->newOrder($amount->value);

            if($this->payment->sendInvoice($order, true)){
                $domain->save();
                return redirect()->back()
                    ->with('successfully', 'Your order has been received. The invoice was sent to your email');
            }
        }

        if($domain->save()){
            return redirect()->back()->with('successfully', 'Your order has been received.');
        }

        return redirect()->back()->with('error', 'Your order is not received.');
    }

    public function resultInvoice()
    {
        $json = file_get_contents('php://input');
        $request = json_decode($json);

        if($this->payment->validateResult($request)){

            $order = Order::where('orderReference', $request->orderReference)->first();

            if(!count($order)){
                return false;
            }

            if($order->orderReference == $request->orderReference
                && $order->amount == $request->amount){

                if($this->saveOrder($order)) return $this->payment->returnAnswer($order);
            }
        }
        return false;
    }

    public function createOrder(Request $request)
    {
        $this->validate($request, ['value' => 'required']);

        $order = $this->newOrder($request->value);

        $form = $this->payment->createForm($order);

        return view('payment.form_pay', compact('form'));
    }

    public function result(Request $request)
    {
        if($this->payment->validateResult($request)){
            return redirect('client/domains')->with('successfully', 'Your balance has been replenished' );
        }

        return redirect('client/domains')->with('error', 'Your balance has not been replenished' );
    }

    protected function newOrder($amount)
    {
        $orderDate = time();
        $user = Auth::user();

        $order =  Order::create([
            'orderReference' => '№' . $orderDate,
            'amount' => $amount,
            'orderDate' => $orderDate,
            'status' => self::NOT_PAID,
            'user_id' => $user->id
        ]);

        return $order;
    }

    protected function saveOrder($order)
    {
        if(!$order->status){
            $order->status = self::PAID;
            if($order->save()){
                $user = User::find($order->user_id);
                $user->balance += $order->amount;
                if($user->save()) return true;
            }
        }
        return false;
    }
}
