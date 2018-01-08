<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTest;
use Tests\TestData;

class ApiMethodTest extends TestCase
{
    public function testGetUserDomains()
    {
        $this->assertTrue(is_array( ApiTest::getInstance()->get_user_domains() ));
    }

    public function testDomainMessages()
    {
        $domain = 'site.ua';
        $site = TestData::createSite($domain, 1, 'file', '', 'message');

        $response = ApiTest::getInstance()->domain_messages($site->domain);
        $this->assertTrue(!isset($response->error));
    }

    public function testDomainConfrim()
    {
        $domain = 'sitetrader.net';
        $site = TestData::createSite($domain, 1, 'not_confirm', '4dbb57b30364e0951258d2f57658bd03');

        $response = ApiTest::getInstance()->domain_confirm($site->id);
        $this->assertTrue(!isset($response->error));
    }
}
