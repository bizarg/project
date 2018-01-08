<?php
namespace App\Scanners;


use App\Builders\MainInfoBuilder;
use App\MainInfo;
use App\Scanners\Helpers\CMS_Detector;
use App\Site;
use App\Types\Error;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Whois;

class MainScanner
{


    public static function request($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // go to redirects
        curl_setopt($ch, CURLOPT_USERAGENT, 'Opera/9.80 (Windows NT 5.1; U; ru) Presto/2.9.168 Version/11.51');  // useragent
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        $content = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if (!preg_match('/^(text\/html|application\/json|text\/xml)/i', $info['content_type'])) {
            $content = '';
        }

        return ['content' => $content, 'info' => $info];
    }

    public static function mainInfoParams(Site $site, $update = false)
    {
        $update = true;
        $mainInfo = null;
        $mainInfo = MainInfo::where('site_id', $site->id)->first();

        if (empty($mainInfo)) {
            $update = true;
        }

        if ($update) {
            $url = $site->main_url;
            if (empty($site->main_url)) {
                $url = 'http://' . $site->domain;
            }


            $resp = self::request($url);

            if ($resp['info']['http_code'] != 200) {
                // $response['error'] = Error::domain_code;
                // return $response;
                throw new ScannerException(Error::domain_code);
            }

            if (empty($site->main_url)) {
                $site->main_url = $resp['info']['url'];
                $site->save();
            }

            if (empty($mainInfo)) {
                $mainInfo = new MainInfo();
                $mainInfo->site_id = $site->id;
            }


            $info = $resp['info'];
            $content = $resp['content'];
            $headers = substr($content, 0, $info ['header_size']);
//        $encoding = 'utf8';

            $headers = self::http_parse_headers($headers);
            $content = substr($content, $info ['header_size']);
            $encoding = mb_detect_encoding($content);

            $content = mb_convert_encoding($content, 'utf8');


            $meta_tags = get_meta_tags($url);
            $location = geoip($info['primary_ip']);

            $mainInfo->expiry_date = self::getExpiredDate($site->domain);
            $mainInfo->title = self::title($content);
            $mainInfo->keywords = !empty($meta_tags['keywords']) ? $meta_tags['keywords'] : null;
            $mainInfo->description = !empty($meta_tags['description']) ? $meta_tags['description'] : null;
            $mainInfo->cms = CMS_Detector::process($content);
            $mainInfo->favicon = self::favicon($site->domain);
            $mainInfo->status = $info ['http_code'];
            $mainInfo->server = !empty($headers['Server']) ? $headers['Server'] : null;
            $mainInfo->ip = $info['primary_ip'];
            $mainInfo->country = $location ['country'];
            $mainInfo->city = $location['city'];
            $mainInfo->time_zone = $location['timezone'];
            $mainInfo->css_framework = self::cssFrameworks($content);
            $mainInfo->js_framework = self::jsFrameworks($content);
            $mainInfo->valid_html = self::validateHtml($site);

            $mainInfo->yandex_metrica = self::yandexMetrica($content);
            $mainInfo->google_analytics = self::googleAnalytics($content);
            $mainInfo->save();

//            $table->integer('site_id');
//            $table->string('title')->nullable();
//            $table->string('keywords')->nullable();
//            $table->string('description')->nullable();
//            $table->string('cms')->nullable();
//            $table->text('favicon')->nullable();
//            $table->string('screenshot')->nullable();
//            $table->integer('status')->nullable();
//            $table->string('server')->nullable();
//            $table->string('ip')->nullable();
//            $table->string('country')->nullable();
//            $table->string('city')->nullable();
//            $table->string('time_zone')->nullable();
//            $table->string('css_framework')->nullable();
//            $table->string('js_framework')->nullable();
//            $table->string('valid_html')->nullable();

        }
        return $mainInfo;

    }

    static private function getExpiredDate($domain)
    {
        $whois = new Whois();
        $whois->deepWhois = false;
        $whois->gtld_recurse = false;
        $result = $whois->lookup($domain);
        foreach ($result['rawdata'] as $raw) {
            if (strpos($raw, 'Expir') !== false) {
                $time = trim(explode(':', $raw, 2)[1]);
                return Carbon::parse($time);
            }
        }
        return null;
    }

    static private function validateHtml(Site $site)
    {

        try{
            $url = 'https://validator.nu/';

            $params = [
                'doc' => $site->main_url,
                'out' => 'json',

            ];
            $opts = array(
                'http' => array(
                    'method' => "GET",
                    'header' => "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.101 Safari/537.36\r\n" .
                        "Content-Type: text/html; charset=UTF-8\r\n"
                )
            );

            $context = stream_context_create($opts);

            $query = http_build_query($params);
            //dd($url . '?' . $query);
            $resp = file_get_contents($url . '?' . $query, null, $context);
        } catch (\Exception $ex) {
            Log::error($ex);
            return null;
        }

        return $resp;
    }

    static private function http_parse_headers($header)
    {
        $retVal = array();
        $fields = explode("\r\n", preg_replace('/\x0D\x0A[\x09\x20]+/', ' ', $header));
        foreach ($fields as $field) {
            if (preg_match('/([^:]+): (.+)/m', $field, $match)) {
                $match[1] = preg_replace_callback('/(?<=^|[\x09\x20\x2D])./', function ($matches) {
                    return strtoupper($matches[0]);
                }, strtolower(trim($match[1])));
                if (isset($retVal[$match[1]])) {
                    $retVal[$match[1]] = array($retVal[$match[1]], $match[2]);
                } else {
                    $retVal[$match[1]] = trim($match[2]);
                }
            }
        }
        return $retVal;
    }

    static private function title($content)
    {
        $res = preg_match("/<title>(.*)<\/title>/siU", $content, $title_matches);
        if (!$res)
            return null;
        $title = preg_replace('/\s+/', ' ', $title_matches[1]);
        $title = trim($title);
        return $title;
    }

    static private function favicon($url)
    {
        $icon = @file_get_contents('https://www.google.com/s2/favicons?domain=' . $url);
        $icon = 'data:image/x-icon;base64,' . base64_encode($icon);
        return $icon;

    }

    /**
     * Проверяет используемые CSS фреймверки
     *
     * @param  string $content
     * @return string $frameworks
     */
    static private function cssFrameworks($content)
    {


        $framework_arr = [];
        $frameworks = [
            'bootstrap.min.css' => 'Bootstrap',
            'bootstrap.css' => 'Bootstrap',
            'skeleton.css' => 'Skeleton',
            'materialize.min.css' => 'Materialize',
            'foundation.min.css' => 'Foundation ZURB',
            'amazium.css' => 'Amazium',
            'kube.min.css' => 'Kube CSS Framework',
            'metro.css' => 'Metro UI',
//            'semantic.min.js' => 'Semantic UI',
            'semantic.min.css' => 'Semantic UI',
            'pure-min.css' => 'Pure.css',
            'uikit.min.css' => 'UIkit',
            //          'uikit.min.js' => 'UIkit'];
        ];

        foreach ($frameworks as $key => $value) {

            if (preg_match('/href=.*?' . $key . '.*?/', $content)) {
                $framework_arr[] = $value;
            }
        }

        //dd($framework_arr);
        return json_encode($framework_arr);
    }

    static private function jsFrameworks($content)
    {


        $jslibs = ['jquery' => 'JQuery',
            'prototype' => 'Prototype',
            'scriptaculous' => 'Script.aculo.us'];

        $js_arr = [];


        foreach ($jslibs as $key => $value) {
            if (preg_match('/src=.*?' . $key . '.*?/', $content)) {

                $js_arr[] = $value;

            }
        }
        return json_encode($js_arr);
    }

    static private function yandexMetrica($content)
    {
        return strripos($content, 'src="//bs.yandex.ru') !== false;
    }

    static private function googleAnalytics($content)
    {
        return preg_match("/<script.*?google-analytics\.com.*?script>/siU", $content);
    }


}