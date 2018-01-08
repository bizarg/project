<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at' ,'desc')->paginate(20);

        return view('admin.order', ['orders' => $orders]);
    }

    public function store(Request $request)
    {
        $rules = [
            'url' => 'required|max:32|min:2|url',
            'tariff' => 'required'
        ];

        $this->validate($request, $rules);

        $order = new Order([
            'url' => $request->url,
            'tariff' => $request->tariff,
            'user_id' => Auth::user()->id
        ]);

        if($order->save()){
            return redirect()->back()->with('successfully', 'Your order has been received');
        } else {
            return redirect()->back()->with('error', 'Your order is not received');
        }

    }
}
