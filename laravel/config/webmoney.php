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
     * merchant.webmoney.ru LMI_SECRET_KEY
     */
    'WM_LMI_SECRET_KEY' => env('WM_LMI_SECRET_KEY', '123456789'),

];