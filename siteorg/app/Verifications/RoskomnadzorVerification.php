<?php

namespace App\Verifications;


use App\Notifications\RoscomnadzorFound;

class RoskomnadzorVerification extends Verification
{
    public function checkParams()
    {
        return $this->verifiable->banned;
    }

    public function getQueue()
    {
        return 'emails';
    }

    public function getProblemNotify()
    {
        return new RoscomnadzorFound($this->site, $this->verifiable);
    }

    public function getOkNotify()
    {
        return new RoscomnadzorFound($this->site, $this->verifiable, 'ok');
    }
}