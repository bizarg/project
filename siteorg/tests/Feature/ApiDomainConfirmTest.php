<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Types\Error;
use Tests\ApiTest;
use Tests\ApiHelper;
use Tests\TestData;
use Tests\TestCase;

class ApiDomainConfirmTest extends TestCase
{
    public function testDomainIdRequiredFail()
    {
        $this->assertTrue(ApiHelper::checkResponse( Error::domain_id_required,
            ApiTest::getInstance()->domain_confirm('') ));
    }

    public function testDomainIdRequiredNotFail()
    {
        $this->assertFalse(ApiHelper::checkResponse( Error::domain_id_required,
            ApiTest::getInstance()->domain_confirm(1) ));
    }

    public function testDomainIdNotFoundFail()
    {
        $domain = 'site.ua';
        $site = TestData::createSite($domain);
        TestData::deleteSite($domain);

        $this->assertTrue(ApiHelper::checkResponse( Error::domain_id_not_found,
            ApiTest::getInstance()->domain_confirm($site->id) ));
    }

    public function testDomainIdNotFoundNotFail()
    {
        $domain = 'site.ua';
        $site = TestData::createSite($domain);

        $this->assertFalse(ApiHelper::checkResponse( Error::domain_id_not_found,
            ApiTest::getInstance()->domain_confirm($site->id) ));
    }

    public function testDomainConfirmErrorFail()
    {
        $domain = 'site.ua';
        $site = TestData::createSite($domain, 1, 'file', '');

        $this->assertTrue(ApiHelper::checkResponse( Error::domain_confirm_error,
            ApiTest::getInstance()->domain_confirm($site->id) ));
    }

    public function testDomainConfirmErrorNotFail()
    {
        $domain = 'sitetrader.net';
        $site = TestData::createSite($domain, 1, 'not_confirm', '4dbb57b30364e0951258d2f57658bd03');

        $this->assertFalse(ApiHelper::checkResponse( Error::domain_confirm_error,
            ApiTest::getInstance()->domain_confirm($site->id) ));
    }

    public function testDomainUserErrorFail()
    {
        $domain = 'site.ua';
        $site = TestData::createSite($domain, 2, 'not_confirm');

        $this->assertTrue(ApiHelper::checkResponse( Error::domain_user_error,
            ApiTest::getInstance()->domain_confirm($site->id) ));
    }

    public function testDomainUserErrorNotFail()
    {
        $domain = 'site.ua';
        $site = TestData::createSite($domain);

        $this->assertFalse(ApiHelper::checkResponse( Error::domain_user_error,
            ApiTest::getInstance()->domain_confirm($site->id) ));
    }
}
