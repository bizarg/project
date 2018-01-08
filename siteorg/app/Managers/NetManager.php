<?php


namespace App\Managers;


use App\Proxy;
use Illuminate\Support\Facades\Log;

class NetManager
{

    private $proxyManager;
    private $proxy;
    private $userAgent = 'Opera/9.80 (Windows NT 5.1; U; en) Presto/2.9.168 Version/11.51';
    protected $proxyType = 'default';
    protected $updateProxy = true;

    /**
     * @return ProxiesManager
     */
    public function getProxyManager()
    {
        return $this->proxyManager;
    }

    /**
     * @param ProxiesManager $proxyManager
     */
    public function setProxyManager($proxyManager)
    {
        $this->proxyManager = $proxyManager;
    }

    protected $curlInfo;
    protected $headers = [
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Encoding: deflate',
        'Accept-Language: en-US,en;q=0.5',
        'Cache-Control: no-cache',
        'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
    ];

    /**
     * @return boolean
     */
    public function isUpdateProxy()
    {
        return $this->updateProxy;
    }

    /**
     * @param boolean $updateProxy
     */
    public function setUpdateProxy($updateProxy)
    {
        $this->updateProxy = $updateProxy;
    }

    /**
     * @return mixed
     */
    public function getCurlInfo()
    {
        return $this->curlInfo;
    }

    /**
     * @param mixed $curlInfo
     */
    public function setCurlInfo($curlInfo)
    {
        $this->curlInfo = $curlInfo;
    }


    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param mixed $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }


    /**
     * @return string
     */
    public function getProxyType()
    {
        return $this->proxyType;
    }

    /**
     * @param string $proxyType
     */
    public function setProxyType($proxyType)
    {
        $this->proxyType = $proxyType;
    }

    /**
     * @return mixed
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }


    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProxy()
    {
        return $this->proxy;
    }

    /**
     * @param Proxy $proxy
     * @return $this
     */
    public function setProxy(Proxy $proxy)
    {
        $this->proxy = $proxy;
        return $this;
    }

    /**
     * NetManager constructor.
     * @param ProxiesManager $proxyManager
     */
    public function __construct(ProxiesManager $proxyManager)
    {
        $this->proxyManager = $proxyManager;
    }

    public function setRndProxy()
    {
        $this->proxy = $this->proxyManager->getRndProxy($this->proxyType);
        return $this;
    }


    public function getContent($url)
    {

        if ($this->isUpdateProxy()) {
            $this->setRndProxy();
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        if (isset($this->proxy)) {
            curl_setopt($curl, CURLOPT_PROXY, $this->proxy->ip . ':' . $this->proxy->port);
            curl_setopt($curl, CURLOPT_PROXYUSERPWD, $this->proxy->login . ':' . $this->proxy->password);
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->getUserAgent());
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        //curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 500);
        //curl_setopt($curl, CURLOPT_TIMEOUT, 100);
        curl_setopt($curl, CURLOPT_NOBODY, 0);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
        $out = curl_exec($curl);
        Log::debug($out);
        $this->curlInfo = curl_getinfo($curl);
        curl_close($curl);
        return $out;
    }


}