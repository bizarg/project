<?php
namespace App\Scanners;


use App\Builders\VKBuilder;
use App\FirefoxProfile;
use App\Scanners\Helpers\Net;
use App\Site;
use App\VK;

class VKScanner
{


    public static function vkLinks(Site $site, $update = false)
    {


         $vk = VK::where('site_id', $site->id)->first();

        if (empty($vk)) {
            $update = true;
        }

        if ($update) {
            $vk = new VK();
            $vk->site_id = $site->id;
            $content = Net::getContent('http://vk.com/share.php?act=count&index=1&url=' . $site->main_url);
            if (!empty($content)) {
                $vk_likes = str_replace('VK.Share.count(1, ', '', $content);
                $vk_likes = str_replace(');', '', $vk_likes);
                $vk->likes = $vk_likes;
                $vk->save();
            }
        }

        return $vk;
    }


}