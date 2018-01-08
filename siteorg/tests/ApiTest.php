<?php

namespace Tests;

class ApiTest
{
    private $auth_key;
    private $api_url;

    static private $instance;

    /**
     * ApiTest constructor.
     */
    private function __construct()
    {
//        $this->auth_key = env('API_TEST_KEY');
//        $this->auth_key = env('API_TEST_URL');
        $this->auth_key = 'gEjU1D';
        $this->api_url = 'http://siteorg.loc/api/v1/';
    }

    static public function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new ApiTest;
        }
        return self::$instance;
    }

    protected function sendRequest($url, $params)
    {
        $ch = curl_init($this->api_url . $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-S-AUTH: ' . $this->auth_key,
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        $content = curl_exec($ch);

        curl_close($ch);

        return $content;
    }

    public function add_domain_to_user($domain, $reg = null)
    {
        $url = 'domain/add';
        $params = [
            'domain' => $domain,
            'registrator' => $reg
        ];

        $response = $this->sendRequest($url, $params);
        return json_decode($response);
    }

    public function domain_confirm($id)
    {
        $url = 'domain/confirm';
        $params = ['id' => $id];

        $response = $this->sendRequest($url, $params);
        return json_decode($response);
    }

    public function get_domain_info_period($domain, $type, $date)
    {
        $url = 'domain/info/period';
        $data = [
            'domain' => $domain,
            'type' => $type,
            'from' => $date
        ];

        $response = $this->sendRequest($url, $data);
        return json_decode($response);
    }

    public function get_domain_info($domain, $type = null)
    {
        $url = 'domain/info';
        $params = [
            'domain' => $domain,
            'type' => $type
        ];

        $response = $this->sendRequest($url, $params);
        return json_decode($response);
    }

    public function get_user_domains()
    {
        $url = 'user/domains';
        $params = [];

        $response = $this->sendRequest($url, $params);
        return json_decode($response);
    }

    public function delete_user_domain($id)
    {
        $url = 'domain/delete';
        $params = ['id' => $id];

        $response = $this->sendRequest($url, $params);
        return json_decode($response);
    }

    public function domain_messages($domain)
    {
        $url = 'domain/messages';
        $data = ['domain' => $domain];

        $response = $this->sendRequest($url, $data);
        return json_decode($response);
    }

    private function __clone()
    {
    }
}
