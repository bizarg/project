<?php


namespace App\Managers;


use App\Managers\Error\YandexProxiTimeOutException;
use App\Proxy;
use Carbon\Carbon;

class YandexProxiesManager extends ProxiesManager
{


    public function getRndProxy($type)
    {
        $proxy = Proxy::where('type', $type)
            ->where('status', 'enabled')
            ->orderBy('updated_at', 'asc')
            ->first();

        if (Carbon::now()->diffInMinutes($proxy->updated_at) < 30) {
            throw  new YandexProxiTimeOutException("yandex proxi tomeout exception");
        }

        $proxy->touch();
        return $proxy;
    }

    public function banProxy(Proxy $proxy, $text = '')
    {
        $proxy->bad += 1;
        $proxy->text = $text;
        $proxy->save();
    }

    public function unBanProxy(Proxy $proxy)
    {
        $proxy->good += 1;
        $proxy->save();
    }
}