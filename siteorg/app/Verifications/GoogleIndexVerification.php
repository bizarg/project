<?php

namespace App\Verifications;


use App\Notifications\GoogleIndexNotFound;

class GoogleIndexVerification extends Verification
{

    public function checkParams()
    {
        return $this->verifiable->index == 0;
    }

    public function getQueue()
    {
        return 'emails';
    }

    public function getProblemNotify()
    {
        return new GoogleIndexNotFound($this->site);
    }

    public function getOkNotify()
    {
        return new GoogleIndexNotFound($this->site, 'ok');
    }
}