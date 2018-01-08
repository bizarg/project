<?php
namespace App\Scanners;


use App\Builders\StatusBuilder;
use App\FirefoxProfile;
use App\Site;
use App\Status;
use App\Verifications\VerificationFactory;
use Carbon\Carbon;

class StatusScanner
{

    static private $mbpsServers = [
        [
            'ip' => '199.115.116.193',
            'port' => 8585,
            'country' => 'US'
        ],
        [
            'ip' => '46.165.193.9',
            'port' => 8585,
            'country' => 'DE'
        ],
        [
            'ip' => '70.38.11.48',
            'port' => 8585,
            'country' => 'CA'
        ],
        [
            'ip' => '119.81.66.222',
            'port' => 8585,
            'country' => 'SG'
        ],


    ];

    public static function speedParams(Site $site, $update = false)
    {
        $status = Status::where('site_id', $site->id)->first();
        if (empty($status)) {
            $update = true;
        }
        if ($update) {
            $status = new Status();
            $status->site_id = $site->id;

            foreach (self::$mbpsServers as $server) {
                $resp = file_get_contents('http://' . $server['ip'] . ':' . $server['port'] . '/api?domain=' . $site->main_url);
                $response[$server['country']] = json_decode($resp, true);
            }
            $status->status = json_encode($response);
            $status->save();
            (new VerificationFactory)->getVerifier($status)->check();
            //StatusVerification::check($site, $status);
        }
        return $status;


    }

    public static function byPeriod(Site $site, $data)
    {
        $query = Status::where('site_id', $site->id);
        if (isset($data['from'])) {
            $query->where('created_at', '>=', Carbon::parse($data['from'])->toDateTimeString());
        }
        if (isset($data['to'])) {
            $query->where('created_at', '<=', Carbon::parse($data['to'])->toDateTimeString());
        }
        return $query->get()->toArray();
    }

}