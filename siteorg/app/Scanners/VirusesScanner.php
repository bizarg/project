<?php
namespace App\Scanners;


use App\Builders\VirusBuilder;
use App\FirefoxProfile;
use App\Jobs\VirusResultMonitor;
use App\Scanners\Helpers\Net;
use App\Site;
use App\Verifications\VerificationFactory;
use App\Virus;
use Carbon\Carbon;

class VirusesScanner
{


    public static function virusParams(Site $site, $update = false)
    {

        $virus = Virus::where('site_id', $site->id)->first();

        if (empty($virus)) {
            $update = true;
            $virus = new Virus();
            $virus->site_id = $site->id;
            $virus->scanning = 0;
        } else {
            if ($virus->scanning && $update) {
                $update = false;
            }
        }

//        if ($update && $virus->scanning) {
//            $virus = new Virus();
//            $virus->site_id = $site->id;
//            $virus->scanning = 0;
//        }

        //if ($update && !$virus->scanning) {
        if ($update) {
            $url = 'http://www.virustotal.com/vtapi/v2/url/scan';
            $data = ['url' => $site->main_url, 'apikey' => env('VIRUSTOTAL_KEY')];

            $content = Net::postContentNP($url, $data);
            $obj = json_decode($content);
            $virus->scanning = 1;
            if ($obj && isset($obj->scan_id)) {
                $virus->scan_id = $obj->scan_id;
            }
            $virus->save();
            dispatch((new VirusResultMonitor($virus))->delay(Carbon::now()->addMinutes(3)));
        }

        return $virus;
    }


    /**
     * @param Site $site
     * @param $scan_id
     * @return array
     */
    public static function getVirusScanResult(Virus $virus)
    {
        $url = 'http://www.virustotal.com/vtapi/v2/url/report';
        $data = ['resource' => $virus->scan_id, 'apikey' => env('VIRUSTOTAL_KEY')];


        $content = Net::postContentNP($url, $data);
        $obj = json_decode($content);
        if (isset($obj) && isset($obj->positives)) {
            $virus->vir_count = $obj->positives;
            $virus->scanning = 0;
            (new VerificationFactory)->getVerifier($virus)->check();

        }

        $virus->save();

    }


}