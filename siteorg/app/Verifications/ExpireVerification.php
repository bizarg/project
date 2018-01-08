<?php

namespace App\Verifications;


use App\Notifications\Expire;
use App\Notifications\SSLExpire;
use Carbon\Carbon;

class ExpireVerification extends Verification
{


    public function checkParams()
    {
         if (!empty($this->verifiable->expired)) {
            $diffdays = Carbon::now()->diffInDays($this->verifiable->expired, false);
             return ($diffdays > 0 && $diffdays <= 30);
        }
    }

    public function getQueue()
    {
        return 'emails';
    }

    public function getProblemNotify()
    {
        return new Expire($this->site, $this->verifiable);
    }

    public function getOkNotify()
    {
        return new Expire($this->site, $this->verifiable, 'ok');
    }
}