<?php
namespace App\Scanners;


use App\Builders\LiveInternetBuilder;
use App\FirefoxProfile;
use App\LiveInternet;
use App\Scanners\Helpers\Net;
use App\Site;

class LiveInternetScanner
{


    public static function liveInternetParams(Site $site, $update = false)
    {
        $liveInternet = LiveInternet::where('site_id', $site->id)->first();

        if (empty($yandex)) {
            $update = true;
        }

        if ($update) {
            $liveInternet = new  LiveInternet();
            $liveInternet->site_id = $site->id;

            $traffic = [];
            $content = Net::getContent('http://counter.yadro.ru/values?site=' . $site->domain);
            if (!empty($content)) {
                // Split response string
                $splitted = explode(";", $content);


                foreach ($splitted as $line) {
                    if (!empty(trim($line))) {
                        $arr = explode("=", trim($line));
                        $arr = array_map('trim', $arr);
                        $traffic[$arr[0]] = $arr[1];
                        if ('LI_site' !== $arr[0]) {
                            $liveInternet->{strtolower($arr[0])} = $arr[1];
                        }

                    }
                }

            }
            $liveInternet->traffic = json_encode($traffic);
            $liveInternet->save();

        }
        return $liveInternet;

    }


}