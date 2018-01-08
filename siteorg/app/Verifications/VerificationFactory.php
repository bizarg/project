<?php
/**
 * Created by PhpStorm.
 * User: Алексей
 * Date: 28.07.2017
 * Time: 10:41
 */

namespace App\Verifications;


use App\Types\MessageType;

class VerificationFactory
{


    /**
     * @param Verifiable $v
     */
    public function getVerifier(Verifiable $v)
    {
        $vr = null;

        switch ($v->getType()) {
            case MessageType::google_index:
                $vr = new GoogleIndexVerification($v);
                break;
            case MessageType::roskomnadzor:
                $vr = new RoskomnadzorVerification($v);
                break;
            case MessageType::ssl_expire:
                $vr = new SSLVerification($v);
                break;
            case MessageType::unavailable:
                $vr = new StatusVerification($v);
                break;
            case MessageType::virus_found:
                $vr = new VirusVerification($v);
                break;
            case MessageType::yandex_index:
                $vr = new YandexIndexVerification($v);
                break;
            case MessageType::domain_expire:
                $vr = new ExpireVerification($v);
                break;
        }
        return $vr;

    }
}