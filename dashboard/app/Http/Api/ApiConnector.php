<?php

namespace App\Http\API;

use Illuminate\Support\Facades\Log;

/**
 * Created by PhpStorm.
 * User: Алексей
 * Date: 15.02.2017
 * Time: 10:04
 */
class ApiConnector
{

    private $auth_key;
    private $api_url;
    //private $base_url = 'http://siteorg.com/api/v1/';
    //private $base_url = 'http://siteorg.local/api/v1/';

    private static $instance;

    /**
     * ApiConnector constructor.
     */
    private function __construct()
    {
    }

    private function __clone()
    {
    }

    static public function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new ApiConnector;
        }
        return self::$instance;
    }

    /**
     * @return string
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $auth_key
     */
    public function setAuthKey($auth_key)
    {
        $this->auth_key = $auth_key;
    }

    /**
     * @return string
     */
    public function getApiUrl()
    {
        return $this->api_url;
    }

    /**
     * @param string $auth_key
     */
    public function setApiUrl($api_url)
    {
        $this->api_url = $api_url;
    }

    protected function sendRequest($url, $params)
    {
        $ch = curl_init($this->api_url . $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-S-AUTH: ' . $this->auth_key,
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

        $content = curl_exec($ch);

        curl_close($ch);
//        dd($content);
        return $content;
    }

    public function get_user_domains()
    {
        $url = 'user/domains';
        $params = [];

        $response = $this->sendRequest($url, $params);
//        dd($response);
        $response_obj = json_decode($response);
//        if (is_null($response_obj)) {
//            abort(500);
//        } else {
            return $response_obj;
//        }
    }

    public function get_domain_info($domain, $type)
    {
        $url = 'domain/info';
        $params = [
            'domain' => $domain,
            'type' => $type
        ];

        $response = $this->sendRequest($url, $params);
        $response_obj = json_decode($response);
//        if (is_null($response_obj)) {
//            echo  $response;
//        } else {
            return $response_obj;
//        }
    }

    public function add_domain_to_user($domain, $registrator = null)
    {
        $url = 'domain/add';
        $params = ['domain' => $domain];

        if (isset($registrator)) {
            $data['registrator'] = $registrator;
        }

        $response = $this->sendRequest($url, $params);
//        dd($response);
        $response_obj = json_decode($response);
//        if (is_null($response_obj)) {
//            abort(500);
//        } else {
            return $response_obj;
//        }
    }

    public function domain_delete($id)
    {
        $api_url = 'domain/delete';
        $data = ['id' => $id];

        $json_str = $this->sendRequest($api_url, $data);
        $obj = json_decode($json_str);
//        if (is_null($obj)) {
//            abort(500);
//        }
        return $obj;
    }

    public function get_domain_info_period($domain, $type, $from)
    {
        $api_url = 'domain/info/period';

        $data = [
            'domain' => $domain,
            'type' => $type,
            'from' => $from
        ];

        $json_str = $this->sendRequest($api_url, $data);
        $obj = json_decode($json_str);
//        if (is_null($obj)) {
//            abort(500);
//        }
        return $obj;
    }

    public function domain_messages($domain)
    {
        $api_url = 'domain/messages';
        $data = ['domain' => $domain];

        $json_str = $this->sendRequest($api_url, $data);
        $obj = json_decode($json_str, true);
//        if (is_null($obj)) {
//            abort(500);
//        }
        return $obj;
    }

    public function domain_confirm($id)
    {
        $url = 'domain/confirm';
        $params = ['id' => $id];

        $json_str = $this->sendRequest($url, $params);
        $obj = json_decode($json_str, true);
//        if (is_null($obj)) {
//            abort(500);
//        }
        return $obj;
    }

//    public function domains_info(array $ids)
//    {
//        $api_url = 'domains/list';
//        $request_type = 'POST';
//        $json_str = $this->send_request($api_url, $request_type, $ids);
//        return json_decode($json_str);
//    }

    public function add_user($name, $email)
    {
        $url = 'user/find';
        $params = [
            'name' => $name,
            'email' => $email
        ];

        $json_str = $this->sendRequest($url, $params);
        $obj = json_decode($json_str);
//        if (is_null($obj)) {
//            abort(500);
//        }
        return $obj;
    }

}