<?php

namespace App\Verifications;


use App\Facades\MessagesManager;
use App\Notifications\RoscomnadzorFound;
use App\Notifications\VirusFound;
use App\Site;
use App\Types\Level;
use App\Types\MessageType;
use Illuminate\Database\Eloquent\Model;

class VirusVerification  extends Verification
{


    public function checkParams()
    {
        return $this->verifiable->vir_count > 0;
    }

    public function getQueue()
    {
        return 'emails';
    }

    public function getProblemNotify()
    {
        return new VirusFound($this->verifiable);
    }

    public function getOkNotify()
    {
        return new VirusFound($this->verifiable, 'ok');
    }
}