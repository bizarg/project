<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ActionM\WebMoneyMerchant\WebMoneyMerchant;


class WebMoneyController extends Controller
{
    private $merchant;

    public function __construct()
    {
        $this->merchant = new WebMoneyMerchant;
    }

    public function index()
    {


        $payment_amount = 10;

        $payment_no = 1;

        $item_name = "nameItem";
//
        $payment_fields = $this->merchant->generatePaymentForm($payment_amount, $payment_no, $item_name);
//
        return view('webmoney-merchant::payment_form', compact('payment_fields'));
    }
    /**
     * Search the order if the request from WebMoney Merchant is received.
     * Return the order with required details for the webmoney request verification.
     *
     * @param Request $request
     * @param $order_id
     * @return mixed
     */
    public static function searchOrderFilter(Request $request, $order_id) {

        // If the order with the unique order ID exists in the database
        $order = Order::where('unique_id', $order_id)->first();

        if ($order) {
            $order['WEBMONEY_orderSum'] = $order->amount; // from your database

            // if the current_order is already paid in your database, return strict "paid";
            // if not, return something else
            $order['WEBMONEY_orderStatus'] = $order->order_status; // from your database
            return $order;
        }

        return false;
    }

    /**
     * When the payment of the order is received from WebMoney Merchant, you can process the paid order.
     * !Important: don't forget to set the order status as "paid" in your database.
     *
     * @param Request $request
     * @param $order
     * @return bool
     */
    public static function paidOrderFilter(Request $request, $order)
    {
        // Your code should be here:
        YourOrderController::saveOrderAsPaid($order);

        // Return TRUE if the order is saved as "paid" in the database or FALSE if some error occurs.
        // If you return FALSE, then you can repeat the failed paid requests on the WebMoney Merchant website manually.
        return true;
    }

    /**
     * Process the request from the WebMoney Merchant route.
     * searchOrderFilter is called to search the order.
     * If the order is paid for the first time, paidOrderFilter is called to set the order status.
     * If searchOrderFilter returns the "paid" order status, then paidOrderFilter will not be called.
     *
     * @param Request $request
     * @return mixed
     */
    public function payOrderFromGate(Request $request)
    {
        return $this->merchant->payOrderFromGate($request);
    }

    /**
     * Returns the service status for WebMoney Merchant request
     */
    public function payOrderFromGateOK()
    {
        return "YES";
    }
}
