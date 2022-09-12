<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use DateTimeImmutable;
use ReflectionClass;
use Monolog\Test\TestCase;

/**
 * Class CategoryTest.
 *
 * @covers \App\Entity\Category
 */
class CategoryTest extends TestCase
{
    /**
     * @var Category
     */
    protected $category;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->category = new Category();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->category);
    }

    public function testGetId(): void
    {
        $expected = 42;
        $property = (new ReflectionClass(Category::class))
            ->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($this->category, $expected);
        $this->assertSame($expected, $this->category->getId());
    }

    public function testGetCreatedAt(): void
    {
        $expected = $this->createMock(DateTimeImmutable::class);
        $property = (new ReflectionClass(Category::class))
            ->getProperty('createdAt');
        $property->setAccessible(true);
        $property->setValue($this->category, $expected);
        $this->assertSame($expected, $this->category->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $expected = $this->createMock(DateTimeImmutable::class);
        $property = (new ReflectionClass(Category::class))
            ->getProperty('createdAt');
        $property->setAccessible(true);
        $this->category->setCreatedAt($expected);
        $this->assertSame($expected, $property->getValue($this->category));
    }

    public function testGetUpdatedAt(): void
    {
        $expected = $this->createMock(DateTimeImmutable::class);
        $property = (new ReflectionClass(Category::class))
            ->getProperty('updatedAt');
        $property->setAccessible(true);
        $property->setValue($this->category, $expected);
        $this->assertSame($expected, $this->category->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $expected = $this->createMock(DateTimeImmutable::class);
        $property = (new ReflectionClass(Category::class))
            ->getProperty('updatedAt');
        $property->setAccessible(true);
        $this->category->setUpdatedAt($expected);
        $this->assertSame($expected, $property->getValue($this->category));
    }

    public function testGetTitle(): void
    {
        $expected = '42';
        $property = (new ReflectionClass(Category::class))
            ->getProperty('title');
        $property->setAccessible(true);
        $property->setValue($this->category, $expected);
        $this->assertSame($expected, $this->category->getTitle());
    }

    public function testSetTitle(): void
    {
        $expected = '42';
        $property = (new ReflectionClass(Category::class))
            ->getProperty('title');
        $property->setAccessible(true);
        $this->category->setTitle($expected);
        $this->assertSame($expected, $property->getValue($this->category));
    }
}
