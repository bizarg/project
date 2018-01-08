<?php

return [
    /*
     * Идентификатор продавца. Данное значение присваивается Вам со стороны WayForPay
     */
    'account' => env('MERCHANT_ACCOUNT', 'test_merch_n1'),
    /*
    * SecretKey торговца
    */
    'secretKey' => env('MERCHANT_SECRET_KEY', 'flk3409refn54t54t*FNJRET'),
    /*
    *  имя страницы обработчика запроса serviceURL
    */
    'service' => [
        'purchase' => '/result',
        'invoice' => '/service'
    ],
];