<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\TestData;
use Tests\ApiTest;
use Tests\ApiHelper;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Types\Error;



class ApiGetDomainInfoPeriodTest extends TestCase
{
    private $type = 'status';
    private $domain = '057.ua';

    public function testRequiredFail()
    {
        $this->assertTrue(ApiHelper::checkResponse( Error::domain_required,
            ApiTest::getInstance()->get_domain_info_period('', $this->type, TestData::getDate()) ));
    }

    public function testRequiredNotFail()
    {
        $this->assertFalse(ApiHelper::checkResponse( Error::domain_required,
            ApiTest::getInstance()->get_domain_info_period('domain', $this->type, TestData::getDate()) ));
    }

    public function testFromDateRequiredFail()
    {
        $this->assertTrue(ApiHelper::checkResponse( Error::from_date_required,
            ApiTest::getInstance()->get_domain_info_period('', $this->type, '') ));
    }

    public function testFromDateRequiredNotFail()
    {
        $this->assertFalse(ApiHelper::checkResponse( Error::from_date_required,
            ApiTest::getInstance()->get_domain_info_period('domain', $this->type, TestData::getDate()) ));
    }

    public function testNotValidDateFail()
    {
        $this->assertTrue(ApiHelper::checkResponse( Error::not_valid_date,
            ApiTest::getInstance()->get_domain_info_period('domain', $this->type, '15.265.23') ));
    }

    public function testNotValidDateNotFail()
    {
        $this->assertFalse(ApiHelper::checkResponse( Error::not_valid_date,
            ApiTest::getInstance()->get_domain_info_period('domain', $this->type, TestData::getDate()) ));
    }


    public function testDomainNotExistFail()
    {
        TestData::deleteSite($this->domain);

        $this->assertTrue(ApiHelper::checkResponse( Error::domain_not_exist,
            ApiTest::getInstance()->get_domain_info_period($this->domain, $this->type, TestData::getDate()) ));
    }

    public function testDomainNotExistNotFail()
    {
        TestData::createSite($this->domain);

        $this->assertFalse(ApiHelper::checkResponse( Error::domain_not_exist,
            ApiTest::getInstance()->get_domain_info_period($this->domain, $this->type, TestData::getDate()) ));
    }

    public function testDomainUserErrorFail()
    {
        TestData::createSite($this->domain, 1, 'not_confirm');

        $this->assertTrue(ApiHelper::checkResponse( Error::domain_user_error,
            ApiTest::getInstance()->get_domain_info_period($this->domain, $this->type, TestData::getDate()) ));
    }

    public function testDomainUserErrorNotFail()
    {
        TestData::createSite($this->domain);

        $this->assertFalse(ApiHelper::checkResponse( Error::domain_user_error,
            ApiTest::getInstance()->get_domain_info_period($this->domain, $this->type, TestData::getDate()) ));
    }

    public function testInfoTypeNotSupportFail()
    {
        TestData::createSite($this->domain);

        $this->assertTrue(ApiHelper::checkResponse( Error::info_type_not_support,
            ApiTest::getInstance()->get_domain_info_period($this->domain, 'statuses', TestData::getDate()) ));
    }

    public function testInfoTypeNotSupportNotFail()
    {
        TestData::createSite($this->domain);

        $this->assertFalse(ApiHelper::checkResponse( Error::info_type_not_support,
            ApiTest::getInstance()->get_domain_info_period($this->domain, 'yandex_index', TestData::getDate()) ));
    }
}
