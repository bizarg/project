<?php

namespace App\Verifications;


use App\Notifications\YandexIndexNotFound;

class YandexIndexVerification extends Verification
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
        return new YandexIndexNotFound($this->site);
    }

    public function getOkNotify()
    {
        return new YandexIndexNotFound($this->site, 'ok');
    }
}