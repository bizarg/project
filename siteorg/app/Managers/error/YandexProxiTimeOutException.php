<?php
namespace App\Managers\Error;


use Exception;

class YandexProxiTimeOutException extends Exception
{


    /**
     * YandexProxiTimeOutException constructor.
     * @param string $message
     */
    public function __construct($message = "yandex proxi tomeout exception")
    {
        parent::__construct($message);

    }
}