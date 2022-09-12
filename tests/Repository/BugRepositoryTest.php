<?php

namespace App\Tests\Repository;

use App\DataFixtures\BugFixtures;
use App\DataFixtures\CategoryFixtures;
use App\DataFixtures\UserFixtures;
use App\Entity\Bug;
use App\Entity\Category;
use App\Entity\User;
use App\Repository\BugRepository;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use App\Tests\IntegrationTestCase;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;

class BugRepositoryTest extends IntegrationTestCase
{
    private BugRepository $repository;
    private CategoryRepository $categoryRepository;
    private UserRepository $userRepository;
    private CategoryFixtures $categoryFixtures;

    public function setUp(): void
    {
        static::createClient();
        $this->repository = $this->getRepository(Bug::class);
        $this->categoryRepository = $this->getRepository(Category::class);
        $this->userRepository = $this->getRepository(User::class);
        $this->categoryFixtures = new CategoryFixtures();
        $this->loadFixtures([
            new UserFixtures(new UserPasswordHasher(
                new PasswordHasherFactory([
                    User::class => new NativePasswordHasher()
                ])
            )),
            $this->categoryFixtures,
            new BugFixtures(),
        ]);
    }

    public function testSaveAndDelete(): void
    {
        $titleExample = base64_encode(random_bytes(10));
//        $category = new Category();
//        $category->setTitle($titleExample);
//        $category->setCreatedAt(new \DateTimeImmutable());
//        $category->setUpdatedAt(new \DateTimeImmutable());
//        $category = $this->categoryFixtures->getReference('category-1');
        $category = $this->categoryRepository->find(1);
        $user = $this->userRepository->find(1);
        $bug = new Bug();
        $bug->setTitle($titleExample);
        $bug->setDescription('some description');
        $bug->setCreatedAt(new \DateTimeImmutable());
        $bug->setUpdatedAt(new \DateTimeImmutable());
        $bug->setCategory($category);
        $bug->setAuthor($user);
        $bug->setStatus(true);
        $this->repository->save($bug);
        $element = $this->repository->findOneBy(['title' => $titleExample]);
        $this->assertNotNull($element->getId());
        $this->repository->delete($bug);
        $element = $this->repository->findOneBy(['title' => $titleExample]);
        $this->assertNull($element);
    }

    public function testQueryNotEmpty(): void
    {
        $result = $this->repository->queryAll();
        $this->assertNotNull($result);
    }

    public function testQueryByAuthorEmpty(): void
    {
        $result = $this->repository->queryByAuthor(new User());
        $this->assertNull($result->getFirstResult());
    }
}
