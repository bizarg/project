<?php

namespace App\Verifications;


use App\Notifications\StatusError;
use Illuminate\Support\Facades\Log;

class StatusVerification extends Verification
{

    private $error;

    public function checkParams()
    {
        $statuses = json_decode($this->verifiable->status);
        $errors = 0;
        foreach ($statuses as $country => $coutry_status) {
            if (!empty($coutry_status->error)) {
                //Log::info($coutry_status);
                $errors++;
                //$this->error = $coutry_status->error;
                //$this->country = $country;
                //return true;
            }
        }
        return $errors >= 3;
        //return false;
    }

    public function getQueue()
    {
        return 'emails';
    }

    public function getProblemNotify()
    {
        return new StatusError($this->site);
    }

    public function getOkNotify()
    {
        return new StatusError($this->site, 'ok');
    }
}