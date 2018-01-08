<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Types\Error;
use App\Types\InfoType;
use App\Types\MessageType;
use Tests\ApiTest;
use Tests\ApiHelper;
use Tests\TestData;
use Tests\TestCase;

class ApiDomainMessagesTest extends TestCase
{
    private $domain = 'site.ua';

    public function testRequiredFail()
    {
        $this->assertTrue(ApiHelper::checkResponse( Error::domain_required,
            ApiTest::getInstance()->domain_messages('') ));
    }

    public function testRequiredNotFail()
    {
        $this->assertFalse(ApiHelper::checkResponse( Error::domain_required,
            ApiTest::getInstance()->domain_messages('domain') ));
    }

    public function testDomainNotFoundFail()
    {
        TestData::deleteSite($this->domain);

        $this->assertTrue(ApiHelper::checkResponse( Error::domain_not_found,
            ApiTest::getInstance()->domain_messages($this->domain) ));
    }

    public function testDomainNotFoundNotFail()
    {
        TestData::createSite($this->domain);

        $this->assertFalse(ApiHelper::checkResponse( Error::domain_not_found,
            ApiTest::getInstance()->domain_messages($this->domain) ));
    }

    public function testMessageTypeUnavailableFail()
    {
        $site = TestData::createFakeSite('fakefake.fake');
        ApiTest::getInstance()->get_domain_info($site->domain, InfoType::status);

        $this->assertTrue(ApiHelper::checkMessageType( MessageType::unavailable,
            ApiTest::getInstance()->domain_messages($site->domain) ));
    }
}
