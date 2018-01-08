<?php


namespace App\Managers;


use App\Proxy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProxiesManager
{
    public function getRndProxy($type)
    {
        $proxies = Proxy::where('type', $type)
            ->where('status', 'enabled')
            ->where(function ($query) {
                $query->where('banned', 0)
                    ->orWhere(function ($query) {
                        $query->where('banned', 1)->where('updated_at', '<',Carbon::create()->addDays(1));
                    });
            })
            ->pluck('id');


        Log::debug('proxy type - ' . $type . ',  count - ' . $proxies->count());
        $this->checkAndNotyfi($type, $proxies->count());
        $id = $proxies[array_rand($proxies->toArray())];
        return Proxy::find($id);
    }

    public function banProxy(Proxy $proxy, $text = '')
    {
        $proxy->banned = 1;
        $proxy->text = $text;
        $proxy->save();
        $this->checkAndNotyfi($proxy->type);
    }

    public function checkCount($type)
    {
        $count = Proxy:: where('type', $type)
            ->where('status', 'enabled')
            ->where(function ($query) {
                $query->where('banned', 0)
                    ->orWhere(function ($query) {
                        $query->where('banned', 1)->where('updated_at', '<=', Carbon::create()->subDay(7));
                    });
            })
            ->count();
        return $count;
    }


    public function checkAndNotyfi($type, $count = -1)
    {
        if ($count == -1) {
            $count = $this->checkCount($type);
        }

        $min = env('MIN_PROXY_GROUP', 10);
        if ($count < $min) {
            Mail::raw('Proxies for ' . $type . " = " . $count, function ($message) {
                $emails = explode(',', env('NOTIFI_EMAILS'));
                $message->to($emails);
                $message->subject('Proxies problem');
                $message->from(env('MAIL_EMAIL'));

            });


        }
    }

}