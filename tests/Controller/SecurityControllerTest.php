<?php

namespace App\Tests\Controller;

use App\DataFixtures\UserFixtures;
use App\Tests\IntegrationTestCase;

class SecurityControllerTest extends IntegrationTestCase
{
    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testLoginGet()
    {
        $crawler = $this->client->request('GET', '/login');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testLogout()
    {
        $crawler = $this->client->request('GET', '/login');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
