<?php

namespace App\Tests\Controller;

use App\Controller\BugController;
use App\DataFixtures\BugFixtures;
use App\DataFixtures\CategoryFixtures;
use App\DataFixtures\UserFixtures;
use App\Entity\User;
use App\Tests\IntegrationTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;

class BugControllerTest extends IntegrationTestCase
{
    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->loadFixtures([
            new UserFixtures(new UserPasswordHasher(
                new PasswordHasherFactory([
                    User::class => new NativePasswordHasher()
                ])
            )),
        ]);
    }

    /**
     * @dataProvider loginAndPasswordDataProvider
     */
    public function testIndex(string $login, string $password)
    {
        $crawler = $this->client->request('GET', '/', [], [], [
            'PHP_AUTH_USER' => $login,
            'PHP_AUTH_PW'   => $password,
        ]);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
