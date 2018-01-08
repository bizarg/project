<?php
namespace App\Scanners\Helpers;

class Net2
{

    static $proxyes = array(
        array('46.28.55.119', 3128, 'testuser:uu3Pee9jei'),
        array('46.28.55.123', 3128, 'testuser:uu3Pee9jei'),
        array('46.28.55.124', 3128, 'testuser:uu3Pee9jei'),
        array('46.28.55.125', 3128, 'testuser:uu3Pee9jei'),
        array('5.63.150.132', 3128, 'testuser:uu3Pee9jei'),
        array('5.63.150.133', 3128, 'testuser:uu3Pee9jei'),
        array('5.63.150.134', 3128, 'testuser:uu3Pee9jei'),
        array('5.63.150.135', 3128, 'testuser:uu3Pee9jei')
    );

    static $proxyes2 = array(
        array('151.80.209.19', 3128, 'testuser:uu3Pee9jei'),
        array('151.80.209.20', 3128, 'testuser:uu3Pee9jei'),
        array('151.80.209.21', 3128, 'testuser:uu3Pee9jei'),
        array('151.80.209.22', 3128, 'testuser:uu3Pee9jei'),
        array('151.80.209.23', 3128, 'testuser:uu3Pee9jei'),
        array('151.80.209.27', 3128, 'testuser:uu3Pee9jei'),
        array('151.80.209.28', 3128, 'testuser:uu3Pee9jei'),
        array('151.80.209.29', 3128, 'testuser:uu3Pee9jei'),
        array('151.80.209.30', 3128, 'testuser:uu3Pee9jei'),
        array('151.80.209.31', 3128, 'testuser:uu3Pee9jei'),
        array('151.80.209.64', 3128, 'testuser:uu3Pee9jei'),
        array('151.80.209.65', 3128, 'testuser:uu3Pee9jei'),
        array('151.80.209.66', 3128, 'testuser:uu3Pee9jei'),
        array('151.80.209.67', 3128, 'testuser:uu3Pee9jei'),
        array('151.80.209.68', 3128, 'testuser:uu3Pee9jei'),
        array('151.80.209.69', 3128, 'testuser:uu3Pee9jei'),
        array('151.80.209.70', 3128, 'testuser:uu3Pee9jei'),
        array('151.80.209.71', 3128, 'testuser:uu3Pee9jei'),
        array('151.80.67.123', 3128, 'testuser:uu3Pee9jei'),
        array('151.80.67.124', 3128, 'testuser:uu3Pee9jei'),
        array('151.80.67.125', 3128, 'testuser:uu3Pee9jei'),
        array('151.80.67.126', 3128, 'testuser:uu3Pee9jei'),
        array('151.80.67.127', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.147', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.148', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.149', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.150', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.151', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.163', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.164', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.165', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.166', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.167', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.171', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.172', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.173', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.174', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.175', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.179', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.180', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.181', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.182', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.183', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.187', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.188', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.189', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.190', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.191', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.195', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.196', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.197', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.198', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.199', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.211', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.212', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.213', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.214', 3128, 'testuser:uu3Pee9jei'),
        array('178.33.98.215', 3128, 'testuser:uu3Pee9jei'),
        array('5.196.121.205', 3128, 'testuser:uu3Pee9jei'),
        array('185.2.137.109', 3128, 'testuser:uu3Pee9jei'),
        array('185.2.137.110', 3128, 'testuser:uu3Pee9jei'),
        array('185.38.184.32', 3128, 'testuser:uu3Pee9jei'),
        array('185.38.184.33', 3128, 'testuser:uu3Pee9jei'),
        array('185.38.184.34', 3128, 'testuser:uu3Pee9jei'),
        array('185.38.184.43', 3128, 'testuser:uu3Pee9jei'),
        array('185.38.184.44', 3128, 'testuser:uu3Pee9jei'),
        array('185.38.184.45', 3128, 'testuser:uu3Pee9jei'),
        array('46.28.55.119', 3128, 'testuser:uu3Pee9jei'),
        array('46.28.55.123', 3128, 'testuser:uu3Pee9jei'),
        array('46.28.55.124', 3128, 'testuser:uu3Pee9jei'),
        array('46.28.55.125', 3128, 'testuser:uu3Pee9jei'),
        array('5.63.150.132', 3128, 'testuser:uu3Pee9jei'),
        array('5.63.150.133', 3128, 'testuser:uu3Pee9jei'),
        array('5.63.150.134', 3128, 'testuser:uu3Pee9jei'),
        array('5.63.150.135', 3128, 'testuser:uu3Pee9jei')
    );

    public static function getContent($url, $useragent = 'Opera/9.80 (Windows NT 5.1; U; en) Presto/2.9.168 Version/11.51')
    {
        //$proxy = self::$proxyes2[rand(0, 7)];
        $proxy = self::$proxyes2[array_rand(self::$proxyes2)];
        //Log::info($proxy);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_PROXY, $proxy[0] . ':' . $proxy[1]);
        curl_setopt($curl, CURLOPT_PROXYUSERPWD, $proxy[2]);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, $useragent);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_NOBODY, 0);

        $headers = [

            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Encoding: deflate',
            'Accept-Language: en-US,en;q=0.5',
            'Cache-Control: no-cache',
            'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $out = curl_exec($curl);
        //Log::notice($url);
        //Log::notice(curl_getinfo($curl));


        curl_close($curl);

        return $out;

    }

    public static function getContentGoogle($url, $useragent = 'Opera/9.80 (Windows NT 5.1; U; en) Presto/2.9.168 Version/11.51')
    {
        //$proxy = self::$proxyes2[rand(0, 7)];
        $proxy = self::$proxyes2[array_rand(self::$proxyes2)];
        //Log::info($proxy);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_PROXY, $proxy[0] . ':' . $proxy[1]);
        curl_setopt($curl, CURLOPT_PROXYUSERPWD, $proxy[2]);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, $useragent);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_NOBODY, 0);

        $headers = [

            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Encoding: deflate',
            'Accept-Language: en-US,en;q=0.5',
            'Cache-Control: no-cache',
            'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $out = curl_exec($curl);
        //Log::notice($url);
        //Log::notice(curl_getinfo($curl));


        curl_close($curl);

        return [$proxy, $out];

    }
}
