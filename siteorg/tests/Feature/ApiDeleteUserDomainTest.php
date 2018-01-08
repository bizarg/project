<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\ApiHelper;
use Tests\ApiTest;
use Tests\TestData;
use App\Types\Error;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiDeleteUserDomainTest extends TestCase
{
    public function testRequiredIdDomainFalse()
    {
        $this->assertTrue(ApiHelper::checkResponse( Error::domain_id_required,
            ApiTest::getInstance()->delete_user_domain('') ));
    }

    public function testRequiredIdDomainNotFalse()
    {
        $this->assertFalse(ApiHelper::checkResponse( Error::domain_id_required,
            ApiTest::getInstance()->delete_user_domain(1) ));
    }

    public function testDeleteUserDomain()
    {
        $domain = 'site.ua';
        $site = TestData::createSite($domain);

        ApiTest::getInstance()->delete_user_domain($site->id);
        $this->assertDatabaseMissing('user_sites', ['site_id' => $site->id]);
    }
}
