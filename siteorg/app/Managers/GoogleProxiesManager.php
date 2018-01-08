<?php


namespace App\Managers;


use App\Managers\Error\YandexProxiTimeOutException;
use App\Proxy;
use Carbon\Carbon;

class GoogleProxiesManager extends ProxiesManager
{


    public function getRndProxy($type)
    {
        $proxies = Proxy::where('type', $type)
            ->where('status', 'enabled')
            ->orderBy('updated_at', 'asc')
            ->get();
        $proxy = $proxies->first();

        if (Carbon::now()->diffInMinutes($proxy->updated_at) < 30) {
            throw  new YandexProxiTimeOutException("google proxi tomeout exception");
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