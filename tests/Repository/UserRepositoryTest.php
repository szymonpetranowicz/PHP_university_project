<?php

namespace App\Tests\Repository;

use App\DataFixtures\UserFixtures;
use App\Entity\Enum\UserRole;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use App\Tests\IntegrationTestCase;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class UserRepositoryTest extends IntegrationTestCase
{
    private UserRepository $repository;

    public function setUp(): void
    {
        static::createClient();
        $this->repository = $this->getRepository(User::class);
        $this->loadFixtures([
            new UserFixtures(new UserPasswordHasher(
                new PasswordHasherFactory([
                    User::class => new NativePasswordHasher()
                ])
            )),
        ]);
    }

    public function testSaveAndDelete(): void
    {
        $exampleEmail = 'testing+' . rand(0, 1000) . '@example.com';
        $user = new User();
        $user->setPassword('any12W!asd');
        $user->setEmail($exampleEmail);
        $user->setRoles([UserRole::ROLE_USER]);
        $this->repository->add($user);
        $element = $this->repository->findOneBy(['email' => $exampleEmail]);
        $this->assertNotNull($element->getId());
        $this->repository->remove($user);
        $element = $this->repository->findOneBy(['email' => $exampleEmail]);
        $this->assertNull($element);
    }

    public function testUpdatePassword(): void
    {
        $password = md5('any123234sca!!');
        $user = $this->repository->find(1);
        $this->repository->upgradePassword($user, $password);
        $this->assertSame($password, $user->getPassword());
    }

    public function testUpdatePasswordException(): void
    {
        $this->expectException(UnsupportedUserException::class);
        $password = md5('any123234sca!!');
        $this->repository->upgradePassword($this->createMock(PasswordAuthenticatedUserInterface::class), $password);
    }

    public function testQueryAllEmpty(): void
    {
        $result = $this->repository->queryAll();
        $this->assertNotNull($result);
    }
}
