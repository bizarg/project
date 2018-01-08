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

    private $auth_key = '2865c256-374a-3997-a85a-1f31958d452b';
    //private $base_url = 'http://siteorg.com/api/v1/';
    //private $base_url = 'http://siteorg.local/api/v1/';

    static private $instance;

    /**
     * ApiConnector constructor.
     */
    private function __construct()
    {
    }

    static public function getInstance()
    {
        if (isset(self::$instance)) {
            return self::$instance;
        } else {
            self::$instance = new ApiConnector;
            return self::$instance;
        }
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

    private function send_request($api_url, $request_type, $data = null)
    {

        $url = env('API_URL') . $api_url;

        //'http://siteorg.com/api/v1/domains/list';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $headers = array('X-S-AUTH: ' . $this->auth_key);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request_type);

        if (isset($data)) {
            if (is_array($data)) {
                $data = json_encode($data);
            }

            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        $str = curl_exec($ch);
        Log::debug($str);
        return $str;
    }

    public function domains()
    {
        $api_url = 'domains';
        $request_type = 'GET';
        $json_str = $this->send_request($api_url, $request_type);
        return json_decode($json_str);
    }

    public function domain_info($id)
    {
        $api_url = 'domain/' . $id;
        $request_type = 'GET';
        $json_str = $this->send_request($api_url, $request_type);
        return json_decode($json_str);
    }

    public function domains_info(array $ids)
    {
        $api_url = 'domains/list';
        $request_type = 'POST';
        $json_str = $this->send_request($api_url, $request_type, $ids);
        return json_decode($json_str);
    }

    public function domain_add($domain, $registrator = null)
    {
        $api_url = 'domain/add';

        $request_type = 'POST';
        $data = ['domain' => $domain];
        if (isset($registrator)) {
            $data['registrator'] = $registrator;
        }
        $json_str = $this->send_request($api_url, $request_type, $data);

        return json_decode($json_str);
    }

    public function domain_delete($id)
    {
        $api_url = 'domain/delete/' . $id;
        $request_type = 'POST';
        $json_str = $this->send_request($api_url, $request_type);
        return json_decode($json_str);
    }

    public function domain_param_history($domain, $param, $start_date)
    {
        $api_url = 'domain/history';
        $request_type = 'POST';
        $data = compact('domain', 'param', 'start_date');
        $json_str = $this->send_request($api_url, $request_type, $data);
        $obj = json_decode($json_str);
        if (is_null($obj)) {
            abort(500);
        }
        return $obj;
    }

    public function domain_notify($domain)
    {
        $api_url = 'domain/notify';
        $request_type = 'POST';
        $data = compact('domain');

        $json_str = $this->send_request($api_url, $request_type, $data);

        return json_decode($json_str, true);
    }

    public function add_user($name, $email)
    {
        $api_url = 'user/add';
        $request_type = 'POST';
        $data = compact('name', 'email');
        $data['lang'] = 'EN';
        $json_str = $this->send_request($api_url, $request_type, $data);

        return json_decode($json_str);
    }

    public function confrim_domain($domain)
    {
        $api_url = 'domain/confirm/' . $domain;
        $request_type = 'GET';
        $json_str = $this->send_request($api_url, $request_type);
        return json_decode($json_str);
    }


}