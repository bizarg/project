<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Types\Error;
use Tests\ApiTest;
use Tests\ApiHelper;
use Tests\TestCase;
use Tests\TestData;

class ApiAddDomainToUserTest extends TestCase
{
    private $domain = 'site.ua';

    public function testRequiredFail()
    {
        $this->assertTrue(ApiHelper::checkResponse( Error::domain_required,
            ApiTest::getInstance()->add_domain_to_user('') ));
    }

    public function testRequiredNotFail()
    {
        $this->assertFalse(ApiHelper::checkResponse( Error::domain_required,
            ApiTest::getInstance()->add_domain_to_user('domain') ));
    }

    public function testMinFail()
    {
        $this->assertTrue(ApiHelper::checkResponse( Error::domain_length_min,
            ApiTest::getInstance()->add_domain_to_user('dss') ));
    }

    public function testMinNotFail()
    {
        $this->assertFalse(ApiHelper::checkResponse( Error::domain_length_min,
            ApiTest::getInstance()->add_domain_to_user('doma') ));
    }

    public function testMaxFail()
    {
        $this->assertTrue(ApiHelper::checkResponse( Error::domain_length_max,
            ApiTest::getInstance()->add_domain_to_user(TestData::randStr(256)) ));
    }

    public function testMaxNotFail()
    {
        $this->assertFalse(ApiHelper::checkResponse( Error::domain_length_max,
            ApiTest::getInstance()->add_domain_to_user(TestData::randStr(255)) ));
    }

    public function testRegexFail()
    {
        $this->assertTrue(ApiHelper::checkResponse( Error::domain_name_error,
            ApiTest::getInstance()->add_domain_to_user('$this->domain.com.') ));
    }

    public function testRegexNotFail()
    {
        $this->assertFalse(ApiHelper::checkResponse( Error::domain_name_error,
            ApiTest::getInstance()->add_domain_to_user('do.co', TestData::randStr(99)) ));
    }

    public function testRegistratorMaxFail()
    {
        $this->assertTrue(ApiHelper::checkResponse( Error::registrator_length_max,
            ApiTest::getInstance()->add_domain_to_user('domain.com', TestData::randStr(101)) ));
    }

    public function testRegistratorMaxNotFail()
    {
        $this->assertFalse(ApiHelper::checkResponse( Error::registrator_length_max,
            ApiTest::getInstance()->add_domain_to_user(TestData::randStr(100) )));
    }

    public function testDomainCodeFail()
    {
        $this->assertTrue(ApiHelper::checkResponse( Error::domain_code,
            ApiTest::getInstance()->add_domain_to_user('domassin123.com') ));
    }

    public function testDomainCodeNotFail()
    {
        $this->assertFalse(ApiHelper::checkResponse( Error::domain_code,
            ApiTest::getInstance()->add_domain_to_user('domain.com') ));
    }

    public function testDomainUserHasFail()
    {
        TestData::createSite($this->domain);

        $this->assertTrue(ApiHelper::checkResponse( Error::domain_user_has,
            ApiTest::getInstance()->add_domain_to_user($this->domain) ));
    }

    public function testDomainUserHasNotFail()
    {
        TestData::deleteSite($this->domain);

        $this->assertFalse(ApiHelper::checkResponse( Error::domain_user_has,
            ApiTest::getInstance()->add_domain_to_user($this->domain) ));
    }

    public function testDomainUserOtherHasFail()
    {
        TestData::createSite($this->domain, 2, 'file');

        $this->assertTrue(ApiHelper::checkResponse( Error::domain_user_other_has,
            ApiTest::getInstance()->add_domain_to_user($this->domain) ));
    }

    public function testDatabaseHas()
    {
        TestData::deleteSite($this->domain);
        ApiTest::getInstance()->add_domain_to_user($this->domain);

        $this->assertDatabaseHas('sites', ['domain' => $this->domain]);
    }
}
