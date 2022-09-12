<?php

namespace App\Tests\Repository;

use App\DataFixtures\CategoryFixtures;
use App\DataFixtures\UserFixtures;
use App\Entity\Category;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Tests\IntegrationTestCase;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;

class CategoryRepositoryTest extends IntegrationTestCase
{
    private CategoryRepository $repository;

    public function setUp(): void
    {
        static::createClient();
        $this->repository = $this->getRepository(Category::class);
        $this->loadFixtures([
            new CategoryFixtures(),
        ]);
    }

    public function testSaveAndDelete(): void
    {
        $titleExample = base64_encode(random_bytes(10));
        $category = new Category();
        $category->setTitle($titleExample);
        $category->setCreatedAt(new \DateTimeImmutable());
        $category->setUpdatedAt(new \DateTimeImmutable());
        $this->repository->save($category);
        $element = $this->repository->findOneBy(['title' => $titleExample]);
        $this->assertNotNull($element->getId());
        $this->repository->delete($category);
        $element = $this->repository->findOneBy(['title' => $titleExample]);
        $this->assertNull($element);
    }

    public function testQueryNotEmpty(): void
    {
        $result = $this->repository->queryAll();
        $this->assertNotNull($result);
    }
}
