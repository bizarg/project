<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Types\Error;
use Tests\TestCase;
use Tests\ApiTest;
use Tests\ApiHelper;
use Tests\TestData;

class ApiGetDomainInfoTest extends TestCase
{
    private $domain = 'site.ua';
    
    public function testRequiredFail()
    {
        $this->assertTrue(ApiHelper::checkResponse( Error::domain_required,
            ApiTest::getInstance()->get_domain_info('') ));
    }

    public function testRequiredNotFail()
    {
        $this->assertFalse(ApiHelper::checkResponse( Error::domain_required,
            ApiTest::getInstance()->get_domain_info('domain') ));
    }

    public function testMinFail()
    {
        $this->assertTrue(ApiHelper::checkResponse( Error::domain_length_min,
            ApiTest::getInstance()->get_domain_info(TestData::randStr(3)) ));
    }

    public function testMinNotFail()
    {
        $this->assertFalse(ApiHelper::checkResponse( Error::domain_length_min,
            ApiTest::getInstance()->get_domain_info(TestData::randStr(4)) ));
    }

    public function testMaxFail()
    {
        $this->assertTrue(ApiHelper::checkResponse( Error::domain_length_max,
            ApiTest::getInstance()->get_domain_info(TestData::randStr(256)) ));
    }

    public function testMaxNotFail()
    {
        $this->assertFalse(ApiHelper::checkResponse( Error::domain_length_max,
            ApiTest::getInstance()->get_domain_info(TestData::randStr(255)) ));
    }

    public function testDomainCodeFail()
    {
        $this->assertTrue(ApiHelper::checkResponse( Error::domain_code,
            ApiTest::getInstance()->get_domain_info('domassin123.com') ));
    }

    public function testDomainCodeNotFail()
    {
        TestData::createSite($this->domain);
        $this->assertFalse(ApiHelper::checkResponse( Error::domain_code,
            ApiTest::getInstance()->get_domain_info($this->domain) ));
    }

    public function testInfoTypeNotSupportFail()
    {
        TestData::createSite($this->domain);
        $this->assertTrue(ApiHelper::checkResponse( Error::info_type_not_support,
            ApiTest::getInstance()->get_domain_info($this->domain, 'type') ));
    }

    public function testInfoTypeNotSupportNotFail()
    {
        TestData::createSite($this->domain);
        $this->assertFalse(ApiHelper::checkResponse( Error::info_type_not_support,
            ApiTest::getInstance()->get_domain_info($this->domain, 'status') ));
    }
}
