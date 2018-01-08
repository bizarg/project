<?php

namespace Tests\Feature;

use Tests\TestData;
use Tests\TestCase;
use Tests\ApiTest;
use App\Types\InfoType;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiDomainInfoTypeTest extends TestCase
{
    private $domain = '07.sk';

    public function testDomainInfoMainInfo()
    {
        TestData::createSite($this->domain, 1, 'file', null, InfoType::main_info);

        $response = ApiTest::getInstance()->get_domain_info($this->domain, InfoType::main_info);
        $this->assertTrue(!isset($response->error));
    }

    public function testDomainInfoScreenshot()
    {
        TestData::createSite($this->domain, 1, 'file', null, InfoType::screenshot);

        $response = ApiTest::getInstance()->get_domain_info($this->domain, InfoType::screenshot);
        $this->assertTrue(!isset($response->error));
    }

    public function testDomainInfoStatus()
    {
        TestData::createSite($this->domain, 1, 'file', null, InfoType::status);

        $response = ApiTest::getInstance()->get_domain_info($this->domain, InfoType::status);
        $this->assertTrue(!isset($response->error));
    }

    public function testDomainInfoYandex()
    {
        TestData::createSite($this->domain, 1, 'file', null, InfoType::yandex);

        $response = ApiTest::getInstance()->get_domain_info($this->domain, InfoType::yandex);
        $this->assertTrue(!isset($response->error));
    }

    public function testDomainInfoYandexIndex()
    {
        TestData::createSite($this->domain, 1, 'file', null, InfoType::yandex_index);

        $response = ApiTest::getInstance()->get_domain_info($this->domain, InfoType::yandex_index);
        $this->assertTrue(!isset($response->error));
    }

    public function testDomainInfoAlexa()
    {
        TestData::createSite($this->domain, 1, 'file', null, InfoType::alexa);

        $response = ApiTest::getInstance()->get_domain_info($this->domain, InfoType::alexa);
        $this->assertTrue(!isset($response->error));
    }

    public function testDomainInfoLiveinternet()
    {
        TestData::createSite($this->domain, 1, 'file', null, InfoType::liveinternet);

        $response = ApiTest::getInstance()->get_domain_info($this->domain, InfoType::liveinternet);
        $this->assertTrue(!isset($response->error));
    }

    public function testDomainInfoGooglePr()
    {
        TestData::createSite($this->domain, 1, 'file', null, InfoType::google_pr);

        $response = ApiTest::getInstance()->get_domain_info($this->domain, InfoType::google_pr);
        $this->assertTrue(!isset($response->error));
    }

    public function testDomainInfoGoogleIndex()
    {
        TestData::createSite($this->domain, 1, 'file', null, InfoType::google_index);

        $response = ApiTest::getInstance()->get_domain_info($this->domain, InfoType::google_index);
        $this->assertTrue(!isset($response->error));
    }

    public function testDomainInfoSsl()
    {
        TestData::createSite($this->domain, 1, 'file', null, InfoType::ssl);

        $response = ApiTest::getInstance()->get_domain_info($this->domain, InfoType::ssl);
        $this->assertTrue(!isset($response->error));
    }

    public function testDomainInfoRoskomnadzor()
    {
        TestData::createSite($this->domain, 1, 'file', null, InfoType::roskomnadzor);

        $response = ApiTest::getInstance()->get_domain_info($this->domain, InfoType::roskomnadzor);
        $this->assertTrue(!isset($response->error));
    }

    public function testDomainInfoVirus()
    {
        TestData::createSite($this->domain, 1, 'file', null, InfoType::virus);

        $response = ApiTest::getInstance()->get_domain_info($this->domain, InfoType::virus);
        $this->assertTrue(!isset($response->error));
    }

    public function testDomainInfoVkLikes()
    {
        TestData::createSite($this->domain, 1, 'file', null, InfoType::vk_likes);

        $response = ApiTest::getInstance()->get_domain_info($this->domain, InfoType::vk_likes);
        $this->assertTrue(!isset($response->error));
    }

    public function testDomainInfoFbLikes()
    {
        TestData::createSite($this->domain, 1, 'file', null, InfoType::fb_likes);

        $response = ApiTest::getInstance()->get_domain_info($this->domain, InfoType::fb_likes);
        $this->assertTrue(!isset($response->error));
    }

    public function testDomainInfoGoogleAnalize()
    {
        TestData::createSite($this->domain, 1, 'file', null, InfoType::google_analize);
        $response = ApiTest::getInstance()->get_domain_info($this->domain, InfoType::google_analize);
        $this->assertTrue(!isset($response->error));
    }
}
