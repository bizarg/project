<?php
namespace App\Scanners;


use App\AlexaRank;
use App\Builders\AlexaBuilder;
use App\Exceptions\ScannerException;
use App\FirefoxProfile;
use App\Scanners\Helpers\Net;
use App\Site;
use App\Types\Error;

class AlexaScanner
{


    public static function alexaRankParams(Site $site, $update = false)
    {
        $alexaRank = AlexaRank::where('site_id', $site->id)->first();
        if (empty($alexaRank)) {
            $update = true;
        }

        if ($update) {
            $alexaRank = new AlexaRank();
            $alexaRank->site_id = $site->id;

            $content = Net::getContent('http://www.alexa.com/siteinfo/' . $site->domain);
            if (empty($content)) {
                //$response['error'] = Error::alexa_no_found;
                //return $response;
                throw new ScannerException(Error::alexa_no_found);
            } else {
                $p = '|alt=\'Global rank icon\'><strong class="metrics-data align-vmiddle">(.*?)</strong>|ims';
                $alexaRank->global_rank = -1;
                if (preg_match($p, $content, $matches)) {
                    if (strpos($matches[1], '-') === false) {
                        $alexaRank->global_rank = preg_replace('/\D/', '', $matches[1]);
                    }
                }


                $p = '|Rank in.*?<strong class="metrics-data align-vmiddle">(.*?)</strong>|ims';
                $alexaRank->country_rank = -1;
                if (preg_match($p, $content, $matches)) {
                    $alexaRank->country_rank = preg_replace('/\D/', '', $matches[1]);
                }

                $p = '|Bounce Rate</h4>.*?<strong class="metrics-data align-vmiddle">(.*?)</strong>|ims';
                $alexaRank->bounce_rate = -1;
                if (preg_match($p, $content, $matches)) {
                    $alexaRank->bounce_rate = (float)filter_var($matches[1], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                }

                $p = '|Daily Pageviews per Visitor</h4>.*?<strong class="metrics-data align-vmiddle">(.*?)</strong>|ims';
                $alexaRank->daily_ppv = -1;
                if (preg_match($p, $content, $matches)) {
                    $alexaRank->daily_ppv = (float)filter_var($matches[1], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                }

                $p = '|Daily Time on Site</h4>.*?<strong class="metrics-data align-vmiddle">(.*?)</strong>|ims';
                $alexaRank->daily_tos = -1;
                if (preg_match($p, $content, $matches)) {
                    $alexaRank->daily_tos = trim($matches[1]);
                }

                $p = '|Search Visits</h4>.*?<strong class="metrics-data align-vmiddle">(.*?)</strong>|ims';
                $alexaRank->sev = -1;
                if (preg_match($p, $content, $matches)) {
                    $alexaRank->sev = (float)filter_var($matches[1], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                }

                $p = '|<td class=\'topkeywordellipsis\'.*?\'table-data-order-number\'>.*?<span>(.*?)</span></td>.*?<span class=\'\'>(.*?)</span></td>|ims';
                $traffic_words = [];
                if (preg_match_all($p, $content, $matches)) {
                    foreach ($matches[1] as $key => $value) {
                        $traffic_words[$value] = (float)filter_var($matches[2][$key], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    }
                }

                $alexaRank->traffic = json_encode($traffic_words);
                $alexaRank->save();

            }

        }
        return $alexaRank;

    }


}