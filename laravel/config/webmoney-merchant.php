<?php

return [

    /*
     * https://merchant.webmoney.ru/conf/guide.asp
     */

    /*
     * merchant.webmoney.ru LMI_PAYEE_PURSE = your purse: Z123456789012
     */
    'WM_LMI_PAYEE_PURSE' => env('WM_LMI_PAYEE_PURSE', 'U306317924746'),

    /*
     * merchant.webmoney.ru LMI_SECRET_X2
     */
    'WM_LMI_SECRET_X20'=> env('WM_LMI_SECRET_X20', '987654321'),

    /*
     * merchant.webmoney.ru LMI_SECRET_KEY
     */
    'WM_LMI_SECRET_KEY' => env('WM_LMI_SECRET_KEY', '123456789'),

    /*
     * Locale for the payment form
     */
    'locale' => 'ru-RU',  // ru-RU || en-US

    /*
     *  SearchOrderFilter
     *  Searches the order in the database and returns order details
     *  Must return the array with:
     *
     *  orderStatus
     *  orderCurrency
     *  orderSum
     */
    'searchOrderFilter' => 'App\Http\Controllers\WebMoneyController::searchOrderFilter', //  'App\Http\Controllers\ExampleController::searchOrderFilter',

    /*
     *  PaidOrderFilter
     *  If current 'orderStatus' from DB != 'paid' then PaidOrderFilter will be called
     *  Update the order into the DB & other actions
     */
    'paidOrderFilter' => 'App\Http\Controllers\WebMoneyController::paidOrderFilter', //  'App\Http\Controllers\ExampleController::paidOrderFilter',

    'payment_forms' => [
        'cards' => false,
        'sberbank' => false,
        'online_banking' => false,
        'mobile' => false,
        'webmoney' => true,
    ],

    // Allowed ip's
    'allowed_ips' => [
        '*',
    ],

    /*
     * The notification that will be sent after the payment request has been received.
     */
    'notification' => \ActionM\WebMoneyMerchant\WebMoneyMerchantNotification::class,

    /*
     * The notifiable to which the notification will be sent. The default
     * notifiable will use the mail and slack configuration specified
     * in this config file.
     */
    'notifiable' => \ActionM\WebMoneyMerchant\WebMoneyMerchantNotifiable::class,

    /*
     * By default notifications are always sent. You can pass a callable to filter
     * out certain notifications. The given callable will receive the notification. If the callable
     * returns false, the notification will not be sent.
     */
    'notificationFilter' => null,

    /*
     * The channels to which the notification will be sent.
     */
    'channels' => ['mail', 'slack'],

    'mail' => [
        'to' => 'chyzhevskiy@mail.ru',  // your email
    ],

    'slack' => [
        'webhook_url' => '', // slack web hook to send notifications
    ],
];
