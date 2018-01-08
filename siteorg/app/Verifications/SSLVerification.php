<?php

namespace App\Verifications;


use App\Notifications\SSLExpire;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SSLVerification extends Verification
{


    public function checkParams()
    {
        if (!empty($this->verifiable->expired)) {
            $expire = new Carbon($this->verifiable->expired);
            $diffdays = Carbon::now()->diffInDays($expire, false);
            $res = ($diffdays > 0 && $diffdays <= 15);
            Log::error($this->site->domain . '  ssl ' . $diffdays . '  res ' . ($res ? '1' : '0'));
            return $res;

        }
    }

    public function getQueue()
    {
        return 'emails';
    }

    public function getProblemNotify()
    {
        return new SSLExpire($this->site, $this->verifiable);
    }

    public function getOkNotify()
    {
        return new SSLExpire($this->site, $this->verifiable, 'ok');
    }
}