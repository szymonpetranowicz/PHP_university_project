<?php

namespace App\Tests\Entity;

use App\Entity\User;
use ReflectionClass;
use Monolog\Test\TestCase;

/**
 * Class UserTest.
 *
 * @covers \App\Entity\User
 */
class UserTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->user = new User();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->user);
    }

    public function testGetId(): void
    {
        $expected = 42;
        $property = (new ReflectionClass(User::class))
            ->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($this->user, $expected);
        $this->assertSame($expected, $this->user->getId());
    }

    public function testGetEmail(): void
    {
        $expected = '42';
        $property = (new ReflectionClass(User::class))
            ->getProperty('email');
        $property->setAccessible(true);
        $property->setValue($this->user, $expected);
        $this->assertSame($expected, $this->user->getEmail());
    }

    public function testSetEmail(): void
    {
        $expected = '42';
        $property = (new ReflectionClass(User::class))
            ->getProperty('email');
        $property->setAccessible(true);
        $this->user->setEmail($expected);
        $this->assertSame($expected, $property->getValue($this->user));
    }

    public function testGetSalt(): void
    {
        $this->assertNull($this->user->getSalt());
    }

    public function testGetUserIdentifier(): void
    {
        $expected = 'userIdentifier';
        $property = (new ReflectionClass(User::class))
            ->getProperty('email');
        $property->setAccessible(true);
        $property->setValue($this->user, $expected);
        $this->assertSame($expected, $this->user->getUserIdentifier());
    }

    public function testGetUsername(): void
    {
        $expected = 'username';
        $property = (new ReflectionClass(User::class))
            ->getProperty('email');
        $property->setAccessible(true);
        $property->setValue($this->user, $expected);
        $this->assertSame($expected, $this->user->getUsername());
    }

    public function testGetRoles(): void
    {
        $expected = ['ROLE_USER'];
        $property = (new ReflectionClass(User::class))
            ->getProperty('roles');
        $property->setAccessible(true);
        $property->setValue($this->user, $expected);
        $this->assertSame($expected, $this->user->getRoles());
    }

    public function testSetRoles(): void
    {
        $expected = ['ROLE_ADMIN'];
        $property = (new ReflectionClass(User::class))
            ->getProperty('roles');
        $property->setAccessible(true);
        $this->user->setRoles($expected);
        $this->assertSame($expected, $property->getValue($this->user));
    }

    public function testGetPassword(): void
    {
        $expected = '42';
        $property = (new ReflectionClass(User::class))
            ->getProperty('password');
        $property->setAccessible(true);
        $property->setValue($this->user, $expected);
        $this->assertSame($expected, $this->user->getPassword());
    }

    public function testSetPassword(): void
    {
        $expected = '42';
        $property = (new ReflectionClass(User::class))
            ->getProperty('password');
        $property->setAccessible(true);
        $this->user->setPassword($expected);
        $this->assertSame($expected, $property->getValue($this->user));
    }
}
