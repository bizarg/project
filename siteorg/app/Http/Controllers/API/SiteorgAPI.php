<?php


namespace App\Http\Controllers\API;


/**
 * Class SiteorgAPI
 * @package App\Http\Controllers\API
 */
class SiteorgAPI
{

    /**
     *
     */
    CONST USER_DOMAINS = 'user/domains';
    /**
     *
     */
    CONST DOMAIN_INFO = 'domain/info';
    /**
     *
     */
    CONST DOMAIN_ADD = 'domain/add';
    /**
     *
     */
    CONST DOMAIN_DELETE = 'domain/delete';
    /**
     *
     */
    CONST USER_FIND = 'user/find';
    /**
     *
     */
    CONST DOMAIN_INFO_PERIOD = 'domain/info/period';
    /**
     *
     */
    CONST DOMAIN_MESSAGES = 'domain/messages';
    /**
     *
     */
    CONST DOMAIN_CONFIRM = 'domain/confirm';


    /**
     * Ключь пользователя для работы с апи
     * @var string
     */
    private $userKey = 'key';

    /**
     * URL для работы с апи
     * @var string
     */
    private $apiUrl = 'http://siteorg.com/api/v1/';

    /**
     * SiteorgAPI constructor.
     * @param string $auth_key
     * @param string $api_url
     */
    public function __construct($userKey, $api_url)
    {
        $this->userKey = $userKey;
        if (isset($api_url)) {
            $this->apiUrl = $api_url;
        }
    }


    /**
     * @param $url
     * @param array $params
     * @return mixed
     * @throws \Exception empty response
     */
    protected function sendRequest($url, $params = [])
    {
        $ch = curl_init($this->apiUrl . $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-S-AUTH: ' . $this->userKey,
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        $content = curl_exec($ch);
        if (empty($content)) {
            throw  new \Exception('API return empty response');
        }
        curl_close($ch);
        return $content;
    }

    /**
     * Список доменов пользователя
     * @return mixed
     * @throws \Exception empty response
     */
    public function userDomains()
    {
        $response = $this->sendRequest(self::USER_DOMAINS);
        $response_obj = json_decode($response);
        return $response_obj;
    }

    /**
     * @param $domain
     * @param $type
     * @return mixed
     * @throws \Exception empty response
     */
    public function domainInfo($domain, $type)
    {

        $response = $this->sendRequest(
            self::DOMAIN_INFO,
            [
                'domain' => $domain,
                'type' => $type
            ]
        );
        $response_obj = json_decode($response);
        return $response_obj;
    }

    /**
     * Добавить домен к списку доменоменов пользователя
     * @param $domain
     * @param null $registrator
     * @return mixed
     */
    public function addUserDomain($domain, $registrator = null)
    {
        $params = ['domain' => $domain];
        if (isset($registrator)) {
            $params ['registrator'] = $registrator;
        }
        $response = $this->sendRequest(self::DOMAIN_ADD, $params);
        $response_obj = json_decode($response);
        return $response_obj;
    }

    /**
     * Удалить домен из списка доменов пользователя
     * @param $id из списка доменов пользователя
     * @return mixed
     */
    public function deleteUserDomain($id)
    {
        $json_str = $this->sendRequest(self::DOMAIN_DELETE, ['id' => $id]);
        $obj = json_decode($json_str);
        return $obj;
    }

    /**
     * История по параметру домена с указанной даты до текущего момента
     * @param $domain
     * @param $type
     * @param $from
     * @return mixed
     */
    public function domainInfoFrom($domain, $type, $from)
    {
        $json_str = $this->sendRequest(
            [
                'domain' => $domain,
                'type' => $type,
                'from' => $from
            ],
            self::DOMAIN_INFO_PERIOD
        );
        $obj = json_decode($json_str, true);
        return $obj;
    }

    /**
     * Список активных сообщений по домену
     * @param $domain
     * @return mixed
     */
    public function domainMessages($domain)
    {
        $json_str = $this->sendRequest(self::DOMAIN_MESSAGES, ['domain' => $domain]);
        $obj = json_decode($json_str, true);
        return $obj;
    }

    /**
     * Подвердить домен пользователя
     * @param $id из списка доменов пользователя
     * @return mixed
     */
    public function domainConfirm($id)
    {
        $json_str = $this->sendRequest(self::DOMAIN_CONFIRM, ['id' => $id]);
        $obj = json_decode($json_str, true);
        return $obj;
    }

 
}