<?php
/**
 * Created by PhpStorm.
 * User: Алексей
 * Date: 27.02.2017
 * Time: 15:38
 */

namespace App\Http\API;

use Carbon\Carbon;
use MCurl\Client;

class PiwikHelper
{
    private $server;
    private $token_auth;
    private $format;
    private static $instance;


    /**
     * PiwikHelper constructor.
     * @param $token_auth
     */
    private function __construct()
    {
        $this->token_auth = env('PIWIK_TOKEN');
        $this->server = env('PIWIK_SERVER');
        $this->format = 'json';
    }

    static public function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new PiwikHelper();
        }
        return self::$instance;
    }

    private function send_request($params, $json = true)
    {
        $params['token_auth'] = $this->token_auth;
        $client = new Client();
        $result = $client->post($this->server, $params);

        if ($json) {
            return $result->getJson();
        } else {
            return $result->getBody();
        }

    }

    public function getAllDomains()
    {
        $params = [
            'module' => 'API',
            'method' => 'SitesManager.getAllSites',
            'format' => $this->format
        ];
        return $this->send_request($params);
    }

    public function addDomains($domain)
    {
        $params = [
            'module' => 'API',
            'method' => 'SitesManager.addSite',
            'siteName' => $domain,
            'urls' => 'http://' . $domain,
            'format' => $this->format
        ];
        return $this->send_request($params);
    }

    public function getSitesIdFromSiteUrl($domain)
    {
        $params = [
            'module' => 'API',
            'method' => 'SitesManager.getSitesIdFromSiteUrl',
            'url' => 'http://' . $domain,
            'format' => $this->format
        ];
        return $this->send_request($params);
    }

    public function getSiteSettings($idSite)
    {
        $params = [
            'module' => 'API',
            'method' => 'SitesManager.getSitesIdFromSiteUrl',
            'idSite' => $idSite,
            'format' => $this->format
        ];
        return $this->send_request($params);
    }

    public function imageGraphget($idSite)
    {
        $params = [
            'module' => 'API',
            'method' => 'ImageGraph.get',
            'idSite' => $idSite,
            'period' => 'day',
            'apiModule' => 'VisitsSummary',
            'apiAction' => 'get',
//            'date' => Carbon::now()->format('Y-m-d')
            'date' => 'previous30'
        ];
        return $this->send_request($params, false);
    }


}