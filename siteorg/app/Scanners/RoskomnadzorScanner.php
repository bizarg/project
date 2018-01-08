<?php
namespace App\Scanners;


use App\Builders\RoskomnadzorBuilder;
use App\FirefoxProfile;
use App\Roskomnadzor;
use App\Scanners\Helpers\Net;
use App\Site;
use App\Verifications\VerificationFactory;

class RoskomnadzorScanner
{

    public static function banParams(Site $site, $update = false)
    {
        $rospotrebnadzor = Roskomnadzor::where('site_id', $site->id)->first();
        if (empty($rospotrebnadzor)) {
            $update = true;
            $rospotrebnadzor = new Roskomnadzor();
            $rospotrebnadzor->site_id = $site->id;
        }

        if ($update) {
            $rospotrebnadzor->banned = 0;
            $content = Net::getContent('http://api.antizapret.info/get.php?item=' . $site->domain . '&type=json');
            if (!empty($content)) {
                $obj = json_decode($content);
                if ($rospotrebnadzor->banned = !empty($obj->register)) {
                    $rospotrebnadzor->domain = $obj->register[0]->domain;
                    $rospotrebnadzor->ip = $obj->register[0]->ip;
                }

            }
            (new VerificationFactory)->getVerifier($rospotrebnadzor)->check();

            $rospotrebnadzor->save();
        }
        return $rospotrebnadzor;

    }

}