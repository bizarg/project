<?php

namespace App\Http\Controllers;

use App\Models\Build;
use App\Models\Country;
use App\Models\Server;
use Illuminate\Http\Request;

class InstallController extends Controller
{
    public function install(Request $request)
    {
        $this->validate($request, [
            'domain' => 'require',
            'app' => 'require',
            'ip' => 'require'
        ]);

        $domain = $request->domain;
        $app = $request->app;
        $ip = $request->ip;

        if ($request->has('directory')) {
            $domain = $domain . '/public_html/s' . $request->directory;
        }

        $_SERVER_HOST = "/CMD_PLUGINS/installatron/index.raw";

        switch ($ip) {
            case '174.127.85.34:2222':
                $_SERVER_USER = "admin";
                $_SERVER_PASS = "FhcC3fNwjN";
                break;
            case '209.95.58.36:2222':
                $_SERVER_USER = "bizarg";
                $_SERVER_PASS = "uhDdTvmhSb";
                break;
            case '193.29.187.103:2222':
                $_SERVER_USER = "bizarg";
                $_SERVER_PASS = "gxpqGtEE8G";
                break;
        }

        $ckfile = public_path().'\tmp\cookie.txt';

//        $arr_domain = explode('/', $domain);

        $query = $_SERVER_HOST."?api=json"
            ."&cmd=install"
            ."&application=".$app
                ."&url=".urlencode($domain)
//            ."&url="
        ;
//
//        for($i = 0; $i < count($arr_domain); $i++) {
//            if ($i == 0) {
//                $query .= urlencode($arr_domain[$i]. '/' .
//                    'public_html' . '/');
//            } elseif ($i == 1) {
//                $query .= urlencode('s'.$arr_domain[$i]. '/');
//            } else {
//                $query .= urlencode($arr_domain[$i]. '/');
//            }
//        }
//        return $query;
        $fields = [
            'referer' => $query,
            'username' => $_SERVER_USER,
            'password' => $_SERVER_PASS,
        ];

        $curl = curl_init("http://" . $ip . "/CMD_LOGIN");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl,CURLOPT_COOKIEJAR, $ckfile);
        curl_setopt($curl,CURLOPT_COOKIEFILE, $ckfile);
        curl_setopt($curl,CURLOPT_POSTFIELDS, $fields);

        $response = curl_exec($curl);
        if ($response === false) {
            $message = 'Error';
        } else {
            $message = json_decode($response);
        }
        curl_close($curl);

        if ($message != 'Error') {
            $answer = array_diff(explode("\n", $message->message), array(''));
        } else {
            $answer = $message;
        }

        return response()->json($answer);
    }

    public function add_domain()
    {
        $countries = Country::all();

        $builds = Build::all();

        return view('add_domain', compact('countries', 'builds'));
    }

    public function getServers(Request $request)
    {
        $country = Country::findOrFail($request->country);
        $servers = $country->servers()->get();

        return response()->json($servers);
    }
}
