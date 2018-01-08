<?php
namespace App\Scanners;


use App\Builders\FBBuilder;
use App\FB;
use App\FirefoxProfile;
use App\Scanners\Helpers\Net;
use App\Site;

class FBScanner
{


    public static function fbLiks(Site $site, $update = false)
    {
        $fb = FB::where('site_id', $site->id)->first();
        if (empty($fb)) {
            $update = true;
        }
        if ($update) {
            $fb = new FB();
            $fb->site_id = $site->id;
            $fb->likes = 0;
            $content = Net::getContent('http://graph.facebook.com/' . $site->main_url);
            $obj = json_decode($content);
            if (isset($obj) && isset($obj->share)) {
                $fb->likes = $obj->share->share_count;
            }
            $fb->save();

        }
        return $fb;
    }

}