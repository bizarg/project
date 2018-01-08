<?php
namespace App\Scanners;


use App\Builders\GoogleAnalizeBuilder;
use App\Builders\GoogleIndexBuilder;
use App\Builders\GoogleParamsBuilder;
use App\FirefoxProfile;
use App\Google;
use App\GoogleAnalize;
use App\GoogleIndex;
use App\GooglePR;
use App\Managers\GoogleProxiesManager;
use App\Managers\NetManager;
use App\Scanners\Helpers\Net;
use App\Site;
use App\Verifications\VerificationFactory;
use Illuminate\Support\Facades\Log;

class GoogleScanner
{


    public static function googleParams(Site $site, $update = false)
    {
        $google = GooglePR::where('site_id', $site->id)->first();

        if (empty($google)) {
            $update = true;
            $google = new GooglePR();
            $google->site_id = $site->id;
        }
        if ($update) {
            $google->pr = self::get_google_pagerank($site->domain);
            $google->save();
        }
        return $google;

    }

    public static function googleIndexParams(Site $site, $update = false)
    {
        //$proxyManager = New ProxiesManager();
        $proxyManager = new GoogleProxiesManager();
        $netManager = new NetManager($proxyManager);
        $netManager->setProxyType('google');

        $google = GoogleIndex::where('site_id', $site->id)->first();

        Log::info('scan google index - ' . $site->domain);

        if (empty($google)) {
            $update = true;
        }

        if ($update) {
            $google = new GoogleIndex();
            $google->site_id = $site->id;
            $google->index = 0;

            // $content = Net2::getContentGoogle();
            $url = 'https://www.google.com/search?hl=en&q=site:' . $site->domain;
            $content = $netManager->getContent($url);
            $p = '|resultStats">(.*?)<|ims';

            if (preg_match($p, $content, $matches)) {
                $google->index = intval(preg_replace('/\D/', '', $matches[1]));
            }

            if ($google->index == 0 && strpos($content, 'did not match any documents') === false) {
                $netManager->getProxyManager()->banProxy($netManager->getProxy(), $content);
                Log::warning($content);
            } else {
                $netManager->getProxyManager()->unBanProxy($netManager->getProxy());
            }
            $google->save();
            (new VerificationFactory)->getVerifier($google)->check();
        }

        //
//        GoogleIndexVerification::check($site, $google);
        return $google;
    }

    private static function get_google_pagerank($url)
    {
        $query = "http://toolbarqueries.google.com/tbr?client=navclient-auto&ch=" . self::CheckHash(self::HashURL($url)) . "&features=Rank&q=info:" . $url . "&num=100&filter=0";
        $data = Net::getContent($query);
        $pos = strpos($data, "Rank_");
        if ($pos === false) {
            return -1;
        } else {
            $pagerank = substr($data, $pos + 9);
            return $pagerank;
        }
    }

    private static function StrToNum($Str, $Check, $Magic)
    {
        $Int32Unit = 4294967296; // 2^32
        $length = strlen($Str);
        for ($i = 0; $i < $length; $i++) {
            $Check *= $Magic;
            if ($Check >= $Int32Unit) {
                $Check = ($Check - $Int32Unit * (int)($Check / $Int32Unit));
                $Check = ($Check < -2147483648) ? ($Check + $Int32Unit) : $Check;
            }
            $Check += ord($Str{$i});
        }
        return $Check;
    }

    private static function HashURL($String)
    {
        $Check1 = self::StrToNum($String, 0x1505, 0x21);
        $Check2 = self::StrToNum($String, 0, 0x1003F);
        $Check1 >>= 2;
        $Check1 = (($Check1 >> 4) & 0x3FFFFC0) | ($Check1 & 0x3F);
        $Check1 = (($Check1 >> 4) & 0x3FFC00) | ($Check1 & 0x3FF);
        $Check1 = (($Check1 >> 4) & 0x3C000) | ($Check1 & 0x3FFF);
        $T1 = (((($Check1 & 0x3C0) << 4) | ($Check1 & 0x3C)) << 2) | ($Check2 & 0xF0F);
        $T2 = (((($Check1 & 0xFFFFC000) << 4) | ($Check1 & 0x3C00)) << 0xA) | ($Check2 & 0xF0F0000);
        return ($T1 | $T2);
    }

    private static function CheckHash($Hashnum)
    {
        $CheckByte = 0;
        $Flag = 0;
        $HashStr = sprintf('%u', $Hashnum);
        $length = strlen($HashStr);
        for ($i = $length - 1; $i >= 0; $i--) {
            $Re = $HashStr{$i};
            if (1 === ($Flag % 2)) {
                $Re += $Re;
                $Re = (int)($Re / 10) + ($Re % 10);
            }
            $CheckByte += $Re;
            $Flag++;
        }
        $CheckByte %= 10;
        if (0 !== $CheckByte) {
            $CheckByte = 10 - $CheckByte;
            if (1 === ($Flag % 2)) {
                if (1 === ($CheckByte % 2)) {
                    $CheckByte += 9;
                }
                $CheckByte >>= 1;
            }
        }
        return '7' . $CheckByte . $HashStr;
    }


    public static function googleAnalizeParams(Site $site, $update = false)
    {
        $google = GoogleAnalize::where('site_id', $site->id)->first();

        if (empty($google)) {
            $update = true;
            $google = new GoogleAnalize();
            $google->site_id = $site->id;
        }
        if ($update) {
            $content = Net::getContent('https://www.googleapis.com/pagespeedonline/v1/runPagespeed?url=' . $site->main_url . '&key=AIzaSyB-wN-VZt0W-j8iNe91cLiLZW4rBL4nQMw', '', false, 100);
            $obj = json_decode($content);
            if (!empty($obj)) {
                $google->info = $content;
                $google->save();
            }
        }
        return $google;


    }
}