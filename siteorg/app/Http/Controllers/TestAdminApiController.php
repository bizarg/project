<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\SiteorgAdminAPI;
use Auth;
use Validator;

class TestAdminApiController extends Controller
{


    private $api_key = '$2y$10$52dFUwEtlnSPMM6UHFujE';
    private $api_url = 'http://dev2.siteorg.com/api/admin/';

    /**
     * @var SiteorgAdminAPI
     */
    private $adminApi;

    /**
     * TestApiController constructor.
     */
    public function __construct()
    {

        $this->adminApi = new SiteorgAdminAPI($this->api_key, $this->api_url);
//        $this->api_url = env('API_TEST_URL');
//        $this->api_key = env('API_TEST_KEY');

    }

    public function testCall($method)
    {
         
        $response = null;
        switch ($method) {
            case 'users':
                
                $response = $this->adminApi->getUsers();
                break;
            case 'addnew':

                $response = $this->adminApi->findOrAddUser('test', 'test'.str_random(2).'@domai.com');
                break;
            case 'find':

                $response = $this->adminApi->findOrAddUser('Robert Babothy', 'info@07.sk');
                break;
            //'userfind':

        }
        dd($response);

    }

}
