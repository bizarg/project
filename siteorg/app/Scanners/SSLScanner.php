<?php
namespace App\Scanners;


use App\Builders\SSLBuilder;
use App\FirefoxProfile;
use App\Google;
use App\Site;
use App\SSL;
use App\Verifications\VerificationFactory;
use Carbon\Carbon;

class SSLScanner
{


    public static function sslParams(Site $site, $update = false)
    {
        $ssl = SSL::where('site_id', $site->id)->first();
        if (empty($ssl)) {
            $update = true;
            $ssl = new SSL();
            $ssl->site_id = $site->id;
        }
        if ($update) {
            $ssl_url = $site->main_url;
            if (strpos($ssl_url, 'https') === false) {
                $ssl_url = str_replace('http', 'https', $ssl_url);
            }
            $curl = curl_init($ssl_url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl, CURLOPT_NOBODY, true);
            curl_setopt($curl, CURLOPT_CERTINFO, true);
            //curl_setopt($curl, CURLOPT_VERBOSE, 1);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);
            curl_exec($curl);
            $certInfo = curl_getinfo($curl, CURLINFO_CERTINFO);


            if (
                //isset($certInfo[0]['Authority Information Access']) &&
                //isset($certInfo[0]['X509v3 Subject Alternative Name']) &&
                //isset($certInfo[0]['X509v3 Basic Constraints']) &&
                //isset($certInfo[0]['X509v3 Key Usage']) &&
                //isset($certInfo[0]['X509v3 CRL Distribution Points']) &&
                isset($certInfo[0]['Subject']) &&
                isset($certInfo[0]['Expire date']) &&
                isset($certInfo[0]['Start date']) &&
                isset($certInfo[0]['Version'])
            ) {
                //Log::info($certInfo[0]);
                preg_match('/(.+)\./i', $site->domain, $domain_match);
                if (preg_match('/' . $domain_match[1] . '/i', is_array($certInfo[0]['Subject']) ? array_pop($certInfo[0]['Subject']) : $certInfo[0]['Subject'])) {
                    $ssl->start = Carbon::parse($certInfo[0]['Start date']);
                    $ssl->expired = Carbon::parse($certInfo[0]['Expire date']);
                    $ssl->save();
                    (new VerificationFactory)->getVerifier($ssl)->check();
                }
            }

        }
        //SSLVerification::check($site, $ssl);
        return $ssl;

    }
}