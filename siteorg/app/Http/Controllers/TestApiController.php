<?php

namespace App\Http\Controllers;

use App\Notifications\DomainMessage;
use App\Notifications\GoogleIndexNotFound;
use App\Notifications\RoscomnadzorFound;
use App\Notifications\SSLExpire;
use App\Notifications\StatusError;
use App\Notifications\YandexIndexNotFound;
use App\Roskomnadzor;
use App\Site;
use App\SSL;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Types\Error;
use Illuminate\Support\Facades\Log;
use Validator;

class TestApiController extends Controller
{


//    private $api_url;
//    private $api_key;
    private $api_key = 'gEjU1D';
    private $api_url = 'http://siteorg2.local/api/v1/';

    /**
     * TestApiController constructor.
     */
    public function __construct()
    {
//        $this->api_url = env('API_TEST_URL');
//        $this->api_key = env('API_TEST_KEY');

    }

    public function testEmail()
    {
        Log::debug('email');
        $user = User::find(1);
        $site = Site::find(7);
        $roskomnadzor = Roskomnadzor::find(4);
        $ssl = SSL::find(3);
        //$user->notify((new RoscomnadzorFound($site, $roskomnadzor ))->onQueue('emails'));
        $user->notify((new GoogleIndexNotFound($site))->onQueue('emails'));

    }

    protected function sendRequest($url, $params)
    {
        //
        $ch = curl_init($this->api_url . $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-S-AUTH: ' . $this->api_key,
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        $content = curl_exec($ch);

        curl_close($ch);

        return $content;
    }

    public function test_user_domains()
    {
        $url = 'user/domains';
        $params = [];

        $response = $this->sendRequest($url, $params);
        $response_obj = json_decode($response);

        dd(gettype($response_obj));
        if (is_null($response_obj)) {
            dd($response);
        } else {
            dd($response_obj);
        }

    }

    public function test_confirm()
    {

        $url = 'domain/confirm';
        $params = ['id' => 2];

        $response = $this->sendRequest($url, $params);
        $response = json_decode($response);
//        dd($response);
//        if(isset($response->error)){
//            if(is_array($response->error)){
//                $response = in_array(Error::domain_confirm_error, $response->error);
//            } else {
//                $response = Error::domain_confirm_error == $response->error;
//            }
//        } else {
//            $response = false;
//        }

        dd($response);

        $this->assertTrue($response);

//        dd($response);
    }

    public function test_domain_add()
    {
        $url = 'domain/add';
        $params = ['domain' => 'hd3.ru', 'registrator' => $this->generate(101)];

        $response = $this->sendRequest($url, $params);
        $response_obj = json_decode($response);

        dd($response_obj);
        if (is_null($response_obj)) {
            dd($response);
        } else {
            dd($response_obj);
        }
    }


    function generate($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $result = '';
        for ($i = 0; $i <= $length; $i++) {
            $result .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $result;
    }

    public function test_domain_info()
    {
        $url = 'domain/info';
        $params = [
            'domain' => 'site.ua',
            'type' => 'main_info'
        ];
        $response = $this->sendRequest($url, $params);
        dd($response);
        $response_obj = json_decode($response);

        if (is_null($response_obj)) {
            echo $response;
        } else {
            dd($response_obj);
        }
    }

    public function test_domain_info_period()
    {
        $url = 'domain/info/period';
        $params = [
            'domain' => '057.ua',
            'type' => 'alexa',
//            'from' => Carbon::now()->subHour()->toDateString(),
            'from' => Carbon::now()->subMonth()->toDateString(),
//            'from' => Carbon::now()->subDay()->toDateString()
//            'from' => '15.265.23'
        ];
        $response = $this->sendRequest($url, $params);
        $response_obj = json_decode($response);

        if (is_null($response_obj)) {
            echo $response;
        } else {
            dd($response_obj);
        }
    }

    public function domain_messages()
    {
        $url = 'domain/messages';
        $data = ['domain' => 'inoro.net'];

        $response = $this->sendRequest($url, $data);
        $response = json_decode($response);

        dd($response->error);
        if (isset($response->error)) {
            if (is_array($response->error)) {
                $response = in_array(Error::domain_confirm_error, $response->error);
            } else {
                $response = Error::domain_confirm_error == $response->error;
            }
        } else {
            $response = false;
        }

        dd($response);


        if (is_null($response)) {
            echo $response;
        } else {
            dd($response);
        }
    }

    public function test_admin_user()
    {
        $url = 'http://siteorg2.local/api/admin/user/find';
        $data = [
            'email' => 'info@07.sk',
            'name' => 'Robert Babothy',
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-S-AUTH: ' . $this->api_key,
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $content = curl_exec($ch);
        print_r($content);
    }
}
