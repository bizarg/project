<?php
namespace App\Scanners;


use App\Builders\SSLBuilder;
use App\DomainExpire;
use App\Facades\MessagesManager;
use App\FirefoxProfile;
use App\Google;
use App\Managers\ProxiesManager;
use App\Scanners\Helpers\Whois;
use App\Site;
use App\Verifications\VerificationFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ExpireScanner
{


    public static function expire(Site $site, $update = false)
    {
        $domainExpire = DomainExpire::where('site_id', $site->id)->first();
        $update = true;
        if (empty($domainExpire)) {
            $update = true;
            $domainExpire = new DomainExpire();
            $domainExpire->site_id = $site->id;
        } elseif (is_null($domainExpire->expired)) {
            $update = true;
        }
        if ($update) {
            $pm = new ProxiesManager();

            $whois = new Whois($pm);
            $info = $whois->lookup($site->domain);

            $expired = self::getExpiredDate($info);
            
            if (is_null($expired)) {
                $domainExpire->expired = self::getValidDate($info);
            }
            if (is_null($expired)) {
                $subject = 'Whois not foud';
                $text = 'Whois not found for ' . $site->domain . "\r\n" .
                    " proxy - " . $whois->proxy->ip . "\r\n" .
                    $info;

                $pm->banProxy($whois->proxy, $expired);
                MessagesManager::adminEmail($subject, $text);
                Log::error($info);
            }
            if (!is_null($expired)) {
                $domainExpire->expired = $expired;
            }

            $domainExpire->save();
            if (!is_null($domainExpire->expired)) {
                (new VerificationFactory)->getVerifier($domainExpire)->check();
            }


        }
        return $domainExpire;

    }

    private static function getExpiredDate($info)
    {

        $lines = explode("\n", $info);

        foreach ($lines as $line) {
            if (stripos($line, 'expir') !== false) {
                $time = trim(explode(':', $line, 2)[1]);
                return Carbon::parse($time);
            }
        }
        return null;
    }

    private static function getValidDate($info)
    {

        $lines = explode("\n", $info);

        foreach ($lines as $line) {
            if (strpos($line, 'Valid-date') !== false) {
                $time = trim(explode(' ', $line, 2)[1]);
                return Carbon::parse($time);
            }
        }
        return null;
    }

}