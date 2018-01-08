<?php

namespace Tests;

use Carbon\Carbon;
use SiteManager;
use App\MainInfo;
use App\Types\InfoType;
use App\ScreenShot;
use App\UserSite;
use App\Site;
use App\GoogleAnalize;
use App\GoogleIndex;
use App\GooglePR;
use App\LiveInternet;
use App\Roskomnadzor;
use App\SSL;
use App\Virus;
use App\YandexIndex;
use App\Yandex;
use App\AlexaRank;
use App\VK;
use App\FB;
use App\Status;
use App\Message;

class TestData
{
    public static function createSite(
        $domain,
        $user_id = 1,
        $confirm = 'file',
        $hash = null,
        $type = null,
        $status = 'enabled'
    ) {
        $site = SiteManager::find_or_create($domain);

        if ($site) {
            $userSite = UserSite::where('site_id', $site->id)->first();
            if ($userSite) {
                $userSite->user_id = $user_id;
                $userSite->confirm = $confirm;
                $userSite->status = $status;
                $userSite->hash = $hash;
                $userSite->save();
            } else {
                $userSite = new UserSite;
                $userSite->user_id = $user_id;
                $userSite->site_id = $site->id;
                $userSite->confirm = $confirm;
                $userSite->status = $status;
                $userSite->hash = $hash;
                $userSite->save();
            }

            if (!is_null($type)) {
                switch ($type) {
                    case InfoType::screenshot:
                        self::screenshot($site->id);
                        break;
                    case InfoType::alexa:
                        self::alexaRank($site->id);
                        break;
                    case InfoType::google_analize:
                        self::googleAnalize($site->id);
                        break;
                    case InfoType::roskomnadzor:
                        self::roskomnadzor($site->id);
                        break;
                    case InfoType::status:
                        self::status($site->id);
                        break;
                    case InfoType::yandex_index:
                        self::yandexIndex($site->id);
                        break;
                    case InfoType::main_info:
                        self::mainInfo($site->id);
                        break;
                    case InfoType::liveinternet:
                        self::liveInternet($site->id);
                        break;
                    case InfoType::google_pr:
                        self::googlePR($site->id);
                        break;
                    case InfoType::google_index:
                        self::googleIndex($site->id);
                        break;
                    case InfoType::vk_likes:
                        self::vk($site->id);
                        break;
                    case InfoType::fb_likes:
                        self::fb($site->id);
                        break;
                    case InfoType::ssl:
                        self::ssl($site->id);
                        break;
                    case InfoType::virus:
                        self::virus($site->id);
                        break;
                    case 'message':
                        self::message($site->id);
                        break;
                    default:
                        break;
                }
            }
        }
        return $site;
    }

    public static function deleteSite($domain)
{
    //Site::where('domain', $domain)->delete();
   // UserSite::where('user_id', 1)->delete();
        //$site = Site::where('domain', $domain)->delete();
        $site = Site::where('domain', $domain)->first();

        if ($site) {
            UserSite::where('site_id', $site->id)->delete();
//            $userSite = UserSite::where('site_id', $site->id)->first();
//
//            if ($userSite) {
//                UserSite::where('site_id', $site->id)->delete();
//            }
            $site->delete();
        }
}

    public static function createFakeSite($domain)
    {
        self::deleteSite($domain);

        $site = Site::create([
            'domain'     => $domain,
            'main_url'   => 'http://'.$domain
        ]);

        UserSite::create([
            'user_id'       => 1,
            'site_id'       => $site->id,
            'notify_level'  => 1,
            'status'        => 'enabled',
            'confirm'       => 'file'
        ]);

        return $site;
    }

    public static function randStr ($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $result = '';
        for ($i = 1; $i <= $length; $i++) {
            $result .= $characters[mt_rand (0, strlen ($characters) - 1)];
        }
        return $result;
    }

    public static function getDate($date = null)
    {
        return (is_null($date)) ? Carbon::now()->subMonth()->toDateString() : $date;
    }

    public static function mainInfo($id)
    {
        $maininfo = new MainInfo();
        $maininfo->site_id = $id;
        $maininfo->save();
    }

    public static function screenshot($id)
    {
        $screenshot = new ScreenShot();
        $screenshot->site_id = $id;
        $screenshot->screenshot = 'screenshot';
        $screenshot->save();
    }

    public static function status($id)
    {
        $status = new Status();
        $status->site_id = $id;
        $status->status = '{"US":{"sBps":89036.378646238,"traffBytes":80261,"error":"","ip":"95.211.6.36","time":901440526,"responseCode":200,"responseMessage":"OK","unknownHost":false},"DE":{"sBps":605012.00292374,"traffBytes":80261,"error":"","ip":"95.211.6.36","time":132660178,"responseCode":200,"responseMessage":"OK","unknownHost":false},"CA":{"sBps":134305.58814309,"traffBytes":80261,"error":"","ip":"95.211.6.36","time":597599855,"responseCode":200,"responseMessage":"OK","unknownHost":false},"SG":{"sBps":40921.769931806,"traffBytes":80261,"error":"","ip":"95.211.6.36","time":1961327678,"responseCode":200,"responseMessage":"OK","unknownHost":false}}';
        $status->save();
    }

    public static function yandex($id)
    {
        $yandex = new Yandex();
        $yandex->site_id = $id;
        $yandex->yaca = 1;
        $yandex->tic = 1;
        $yandex->save();
    }

    public static function yandexIndex($id)
    {
        $yandexIndex = new YandexIndex();
        $yandexIndex->site_id = $id;
        $yandexIndex->index = 1;
        $yandexIndex->index_text = 'text';
        $yandexIndex->save();
    }

    public static function alexaRank($id)
    {
        $alexaRank = new AlexaRank();
        $alexaRank->site_id = $id;
        $alexaRank->global_rank = 158747;
        $alexaRank->country_rank = 158747;
        $alexaRank->bounce_rate = 158747;
        $alexaRank->daily_ppv = 158747;
        $alexaRank->daily_tos = 158747;
        $alexaRank->sev = 1;
        $alexaRank->save();
    }

    public static function liveInternet($id)
    {
        $liveInternet = new LiveInternet();
        $liveInternet->site_id = $id;
        $liveInternet->traffic = 'longtext';
        $liveInternet->save();
    }

    public static function googlePR($id)
    {
        $googlePR = new GooglePR();
        $googlePR->site_id = $id;
        $googlePR->pr = 1;
        $googlePR->save();
    }

    public static function googleIndex($id)
    {
        $googleIndex = new GoogleIndex();
        $googleIndex->site_id = $id;
        $googleIndex->index = 1;
        $googleIndex->save();
    }

    public static function ssl($id)
    {
        $ssl = new SSL();
        $ssl->site_id = $id;
        $ssl->start = Carbon::now()->subDay()->toDateString();
        $ssl->expired = Carbon::now()->subDay(2)->toDateString();
        $ssl->save();
    }

    public static function roskomnadzor($id)
    {
        $roskomnadzor = new Roskomnadzor();
        $roskomnadzor->site_id = $id;
        $roskomnadzor->banned = 0;
        $roskomnadzor->save();
    }

    public static function virus($id)
    {
        $virus = new Virus();
        $virus->site_id = $id;
        $virus->scan_id = 1;
        $virus->vir_count = -1;
        $virus->scanning = 0;
        $virus->save();
    }

    public static function vk($id)
    {
        $vk = new VK();
        $vk->site_id = $id;
        $vk->likes = 1;
        $vk->save();
    }
    public static function fb($id)
    {
        $fb = new FB();
        $fb->site_id = $id;
        $fb->likes = 1;
        $fb->save();
    }

    public static function googleAnalize($id)
    {
        $googleAnalize = new GoogleAnalize();
        $googleAnalize->site_id = $id;
        $googleAnalize->info = 'longtext';
        $googleAnalize->save();
    }

    public static function message($id)
    {
        $message = new Message();
        $message->site_id = $id;
        $message->level = 1;
        $message->status = 'show';
        $message->sended = 1;
        $message->type = 'request.json.error';
        $message->save();
    }
}