<?php

namespace App\Managers;

use App\Jobs\AlexaMonitor;
use App\Jobs\ExpireMonitor;
use App\Jobs\FBLikesMonitor;
use App\Jobs\GoogleAnalizeMonitor;
use App\Jobs\GoogleMonitor;
use App\Jobs\GoogleParamsMonitor;
use App\Jobs\LiveInterneMonitor;
use App\Jobs\RosNadzorMonitor;
use App\Jobs\ScreenShotMonitor;
use App\Jobs\SSLMonitor;
use App\Jobs\StatusMonitor;
use App\Jobs\VirusesMonitor;
use App\Jobs\VKLikesMonitor;
use App\Jobs\YandexMonitor;
use App\Jobs\YandexParamsMonitor;
use App\Scanners\MainScanner;
use App\Site;
use App\Types\InfoType;
use Illuminate\Support\Facades\Log;

class SiteManager
{

    public $monitors =
        [
            InfoType::main_info =>
                [
                    'class' => 'App\MainInfo',
                    'scan' => 'App\Scanners\MainScanner::mainInfoParams',
                    'period' => 24,
                    'history' => 0,

                ],

            InfoType::screenshot =>
                [
                    'class' => 'App\ScreenShot',
                    'scan' => 'App\Scanners\ScreenShotScanner::screenParams',
                    'period' => 168,
                    'history' => 1,

                ],
            InfoType::status =>
                [
                    'class' => 'App\Status',
                    'scan' => 'App\Scanners\StatusScanner::speedParams',
                    'period' => 1,
                    'history' => 1,
                ],
            InfoType::yandex =>
                [
                    'class' => 'App\Yandex',
                    'scan' => 'App\Scanners\YandexScanner::yandexParams',
                    'period' => 168,
                    'history' => 0,
                ],
            InfoType::yandex_index =>
                [
                    'class' => 'App\YandexIndex',
                    'scan' => 'App\Scanners\YandexScanner::yndexIndexParams',
                    //'period' => 24,
                    'period' => 120,
                    'history' => 1,
                ],
            InfoType::alexa =>
                [
                    'class' => 'App\AlexaRank',
                    'scan' => 'App\Scanners\AlexaScanner::alexaRankParams',
                    'period' => 24,
                    'history' => 1,
                ],
            InfoType::liveinternet =>
                [
                    'class' => 'App\LiveInternet',
                    'scan' => 'App\Scanners\LiveInternetScanner::liveInternetParams',
                    'period' => 24,
                    'history' => 1,
                ],
            InfoType::google_pr =>
                [
                    'class' => 'App\GooglePR',
                    'scan' => 'App\Scanners\GoogleScanner::googleParams',
                    'period' => 24,
                    'history' => 1,
                ],
            InfoType::google_index =>
                [
                    'class' => 'App\GoogleIndex',
                    'scan' => 'App\Scanners\GoogleScanner::googleIndexParams',
                    //'period' => 24,
                    'period' => 120,
                    'history' => 1,
                ],
            InfoType::ssl =>
                [
                    'class' => 'App\SSL',
                    'scan' => 'App\Scanners\SSLScanner::sslParams',
                    'period' => 360,
                    'history' => 0,
                ],
            InfoType::roskomnadzor =>
                [
                    'class' => 'App\Roskomnadzor',
                    'scan' => 'App\Scanners\RoskomnadzorScanner::banParams',
                    'period' => 24,
                    'history' => 0,
                ],
            InfoType::virus =>
                [
                    'class' => 'App\Virus',
                    'scan' => 'App\Scanners\VirusesScanner::virusParams',
                    'period' => 24,
                    'history' => 0,
                ],
            InfoType::vk_likes =>
                [
                    'class' => 'App\VK',
                    'scan' => 'App\Scanners\VKScanner::vkLinks',
                    'period' => 24,
                    'history' => 1,
                ],
            InfoType::fb_likes =>
                [
                    'class' => 'App\FB',
                    'scan' => 'App\Scanners\FBScanner::fbLiks',
                    'period' => 24,
                    'history' => 1,
                ],
            InfoType::google_analize =>
                [
                    'class' => 'App\GoogleAnalize',
                    'scan' => 'App\Scanners\GoogleScanner::googleAnalizeParams',
                    'period' => 168,
                    'history' => 0,
                ],

            InfoType::expire =>
                [
                    'class' => 'App\DomainExpire',
                    'scan' => 'App\Scanners\ExpireScanner::expire',
                    //'period' => 120,
                     'period' => 24,
                    'history' => 0,
                ],
        ];


    public function getInfoTypes()
    {
        return array_keys($this->monitors);
    }

    public function getInfoTypesPeriod()
    {
        return array_keys(array_filter($this->monitors, function ($var) {
            return $var['history'];
        }));
    }

    public function getMonitor($type)
    {
        return $this->monitors[$type];
    }

    public function find_or_create($domain, $main_url = null)
    {

        $domain = strtolower($domain);
        $site = Site::where('domain', $domain)->first();
        if (!isset($site)) {
            $url = 'http://' . $domain;
            if (isset($main_url))
                $url = $main_url;
            $resp = MainScanner::request($url);
            if ($resp['info']['http_code'] == 200) {
                $site = new Site;
                $site->domain = $domain;
                $site->main_url = $resp['info']['url'];
                $site->save();
            } else {
                Log::debug($resp['info']);
            }
        }

        return $site;
    }

    public function add_to_monitring(Site $site)
    {
        dispatch(new AlexaMonitor($site));
        dispatch(new FBLikesMonitor($site));
        dispatch(new GoogleAnalizeMonitor($site));
        dispatch(new GoogleMonitor($site));
        dispatch(new GoogleParamsMonitor($site));
        dispatch(new LiveInterneMonitor($site));
        dispatch(new RosNadzorMonitor($site));
        dispatch(new ScreenShotMonitor($site));
        dispatch(new SSLMonitor($site));
        dispatch(new StatusMonitor($site));
        dispatch(new VirusesMonitor($site));
        dispatch(new VKLikesMonitor($site));
        dispatch(new YandexMonitor($site));
        dispatch(new YandexParamsMonitor($site));
        dispatch(new ExpireMonitor($site));

    }

    public function needMonitor(Site $site)
    {
        $usersite = UserSite::where('site_id', $site->id)
            ->where('status', 'enabled')
            ->where('confirm', '!=', 'not_confirm')
            ->first();
        return isset($usersite);
    }

    /**
     * @param $site
     * @param $type
     * @param $update
     * @return \App\Status|array
     */
    public function scan($site, $type, $update)
    {

        $scanner = $this->getMonitor($type);
        return call_user_func_array($scanner['scan'], [$site, $update]);

    }
}