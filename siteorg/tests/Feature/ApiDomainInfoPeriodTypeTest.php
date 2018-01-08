<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\TestData;
use Tests\ApiTest;
use App\Types\InfoType;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;


class ApiDomainInfoPeriodTypeTest extends TestCase
{
    private $domain = 'site.ua';

    public function testDomainParamHistoryScreenshots()
    {
        TestData::createSite($this->domain, 1, 'file', null, InfoType::screenshot);
        $response = ApiTest::getInstance()->get_domain_info_period($this->domain, InfoType::screenshot, TestData::getDate());
        $this->assertTrue(!isset($response->error));
    }

    public function testDomainParamHistoryStatus()
    {
        TestData::createSite($this->domain, 1, 'file', null, InfoType::status);
        $response = ApiTest::getInstance()->get_domain_info_period($this->domain, InfoType::status, TestData::getDate());
        $this->assertTrue(!isset($response->error));
    }

    public function testDomainParamHistoryAlexa()
    {
        TestData::createSite($this->domain, 1, 'file', null, InfoType::alexa);
        $response = ApiTest::getInstance()->get_domain_info_period($this->domain, InfoType::alexa, TestData::getDate());
        $this->assertTrue(!isset($response->error));
    }

    public function testDomainParamHistoryLiveinternet()
    {
        TestData::createSite($this->domain, 1, 'file', null, InfoType::liveinternet);
        $response = ApiTest::getInstance()->get_domain_info_period($this->domain, InfoType::liveinternet, TestData::getDate());
        $this->assertTrue(!isset($response->error));
    }

    public function testDomainParamHistoryGooglePr()
    {
        TestData::createSite($this->domain, 1, 'file', null, InfoType::google_pr);
        $response = ApiTest::getInstance()->get_domain_info_period($this->domain, InfoType::google_pr, TestData::getDate());
        $this->assertTrue( !isset($response->error));
    }

    public function testDomainParamHistoryYandexIndex()
    {
        TestData::createSite($this->domain, 1, 'file', null, InfoType::yandex_index);
        $response = ApiTest::getInstance()->get_domain_info_period($this->domain, InfoType::yandex_index, TestData::getDate());
        $this->assertTrue(!isset($response->error));
    }

    public function testDomainParamHistoryGoogleIndex()
    {
        TestData::createSite($this->domain, 1, 'file', null, InfoType::google_index);
        $response = ApiTest::getInstance()->get_domain_info_period($this->domain, InfoType::google_index, TestData::getDate());
        $this->assertTrue(!isset($response->error));
    }

    public function testDomainParamHistoryVkLikes()
    {
        TestData::createSite($this->domain, 1, 'file', null, InfoType::vk_likes);
        $response = ApiTest::getInstance()->get_domain_info_period($this->domain, InfoType::vk_likes, TestData::getDate());
        $this->assertTrue(!isset($response->error));
    }

    public function testDomainParamHistoryFbLikes()
    {
        TestData::createSite($this->domain, 1, 'file', null, InfoType::fb_likes);
        $response = ApiTest::getInstance()->get_domain_info_period($this->domain, InfoType::fb_likes, TestData::getDate());
        $this->assertTrue(!isset($response->error));
    }
}
