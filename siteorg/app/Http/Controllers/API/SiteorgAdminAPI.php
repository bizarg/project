<?php


namespace App\Http\Controllers\API;

/**
 * Class SiteorgAdminAPI
 * @package App\Http\Controllers\API
 */
class SiteorgAdminAPI
{

    /**
     *
     */
    CONST USER_FIND = 'user/find';
    /**
     *
     */
    CONST USERS = 'users';

    /**
     * Ключь пользователя для работы с апи
     * @var string
     */
    private $adminKey = 'key';


    /**
     * URL для работы с апи
     * @var string
     */
    private $apiUrl = 'http://siteorg.com/api/admin/';

    /**
     * SiteorgAPI constructor.
     * @param string $auth_key
     * @param string $api_url
     */
    public function __construct($adminKey, $api_url = null)
    {
        $this->adminKey = $adminKey;
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
            'X-S-AUTH: ' . $this->adminKey,
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
     * Найти или создать нового пользователя. Пользователь индефицируется по майлу
     * @param $name
     * @param $email
     * @return mixed
     */
    public function findOrAddUser($name, $email)
    {
        $json_str = $this->sendRequest(
            self::USER_FIND,
            [
                'name' => $name,
                'email' => $email
            ],
            true
        );
        $obj = json_decode($json_str);
        return $obj;
    }


    /**
     * Получить список созданных пользователей
     * @return mixed
     */
    public function getUsers()
    {
        $json_str = $this->sendRequest(self::USERS);
        $obj = json_decode($json_str);
        return $obj;
    }
}