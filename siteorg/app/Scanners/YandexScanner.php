<?php
namespace App\Scanners;


use App\Builders\YandexIndexBuilder;
use App\Builders\YandexParamsBuilder;
use App\FirefoxProfile;
use App\Managers\NetManager;
use App\Managers\ProxiesManager;
use App\Managers\YandexProxiesManager;
use App\Managers\YndexProxiesManager;
use App\Site;
use App\Verifications\VerificationFactory;
use App\Yandex;
use App\YandexIndex;
use Illuminate\Support\Facades\Log;

class YandexScanner
{


    public static function yandexParams(Site $site, $update = false)
    {
        $yandex = Yandex::where('site_id', $site->id)->first();
        $proxyManager = New ProxiesManager();
        $netManager = new NetManager($proxyManager);
        $netManager->setProxyType('yandex');


        if (empty($yandex)) {
            $update = true;
            $yandex = new Yandex();
            $yandex->site_id = $site->id;
        }

        if ($update) {
            $url = 'http://bar-navig.yandex.ru/u?ver=2&show=32&url=' . $site->main_url;
            //$content = Net::getContent('http://bar-navig.yandex.ru/u?ver=2&show=32&url=' . $site->main_url);
            $content = $netManager->getContent($url);

            $yandex->tic = 0;
            $yandex->yaca = 0;
            try {
                $xml = simplexml_load_string($content);
                $yandex->tic = isset($xml->tcy['value']) ? intval($xml->tcy['value']) : 0;
                $yandex->yaca = strlen(trim($xml->textinfo)) > 1;
                $yandex->yaca_theme = trim($xml->textinfo);
            } catch (\Exception $ex) {
            }
            $yandex->save();
        }
        return $yandex;

    }


    public static function yndexIndexParams(Site $site, $update = false)
    {
         $yandexIndex = YandexIndex::where('site_id', $site->id)->first();
        $proxyManager = New YandexProxiesManager();
        $netManager = new NetManager($proxyManager);
        $netManager->setProxyType('yandex_index');

        if (empty($yandexIndex)) {
            $update = true;
        }

        if ($update) {
            $yandexIndex = new YandexIndex();

            $yandexIndex->site_id = $site->id;
            $yandexIndex->index = 0;
            $yandexIndex->index_text = '';

            $url = 'https://yandex.ru/search/?text=site:' . $site->domain;
            $content = $netManager->getContent($url);
            dd('rdgdfgdfhfhd');
            Log::warning('proxy request yandex_index - ' . $netManager->getProxy()->ip);
  
            $p = '/<div class="serp-adv__found">(.*?)<\/div>/ims';
            if (preg_match($p, $content, $matches)) {
                $count = (int)preg_replace('/[^0-9]/', '', $matches[1]);
                if (strpos($matches[1], 'тыс.')) {
                    $count *= 1000;
                } elseif (strpos($matches[1], 'млн')) {
                    $count *= 1000000;
                }
                $yandexIndex->index = $count;
                $yandexIndex->index_text = $matches[1];
                $netManager->getProxyManager()->unBanProxy($netManager->getProxy());

            } else {
                if (strpos($content, 'ничего не нашлось') === false) {
                    $netManager->getProxyManager()->banProxy($netManager->getProxy(), $content);
//                    $subject = 'Yandex parse problem';
//                    $text = 'Yandex parse for ' . $site->domain . "\r\n" .
//                        " proxy - " . $netManager->getProxy()->ip . ':' . $netManager->getProxy()->port . "\r\n";
//                    MessagesManager::adminEmail($subject, $text);
                    Log::warning('ban proxy - ' . $netManager->getProxy()->ip . ':' . $netManager->getProxy()->port . "\r\n" . $content);
                } else {
                    $netManager->getProxyManager()->unBanProxy($netManager->getProxy());
                }
            }

            (new VerificationFactory)->getVerifier($yandexIndex)->check();

            $yandexIndex->save();
        }
        return $yandexIndex;

    }

//    public static function getIndex($yandex, $site)
//    {
//        $content = Net::getContent('https://yandex.ru/search/?text=site:' . $site->domain);
//        $p = '/<div class="serp-adv__found">(.*?)<\/div>/ims';
//
//        if (preg_match($p, $content, $matches)) {
//            $count = (int)preg_replace('/[^0-9]/', '', $matches[1]);
//            if (strpos($matches[1], 'тыс.')) {
//                $count *= 1000;
//            } elseif (strpos($matches[1], 'млн')) {
//                $count *= 1000000;
//            }
//            $yandex->index = $count;
//            $yandex->index_text = $matches[1];
//        } else {
//            $yandex->index = 0;
//            $yandex->index_text = '';
//        }
//    }


}