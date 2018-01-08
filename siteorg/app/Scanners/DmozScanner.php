<?php
namespace App\Scanners;


use App\Dmoz;
use App\FirefoxProfile;
use App\Site;

class DmozScanner
{


    public static function scan(Site $site, $update = false)
    {
        $dmoz = Dmoz::where('site_id', $site->id)->first();

        if (empty($dmoz)) {
            $update = true;
            $dmoz = new Dmoz();
            $dmoz->site_id = $site->id;
        }

        if ($update) {
            //$content = Net::getContent('http://www.dmoz.org/search/?q=u:' . $site->domain);
            $dmoz->dmoz = false;
            $dmoz->save();
        }
        return $dmoz->toArray();

    }




}