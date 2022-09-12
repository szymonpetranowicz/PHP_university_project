<?php

namespace App\Tests\Entity;

use App\Entity\Bug;
use App\Entity\Category;
use App\Entity\User;
use DateTimeImmutable;
use Monolog\Test\TestCase;
use ReflectionClass;

/**
 * Class BugTest.
 *
 * @covers \App\Entity\Bug
 */
class BugTest extends TestCase
{
    /**
     * @var Bug
     */
    protected $bug;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /* @todo Correctly instantiate tested object to use it. */
        $this->bug = new Bug();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->bug);
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetId(): void
    {
        $expected = 42;
        $property = (new ReflectionClass(Bug::class))
            ->getProperty('id');
        $property->setValue($this->bug, $expected);
        $this->assertSame($expected, $this->bug->getId());
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetCreatedAt(): void
    {
        $expected = $this->createMock(DateTimeImmutable::class);
        $property = (new ReflectionClass(Bug::class))
            ->getProperty('createdAt');
        $property->setValue($this->bug, $expected);
        $this->assertSame($expected, $this->bug->getCreatedAt());
    }

    /**
     * @throws \ReflectionException
     */
    public function testSetCreatedAt(): void
    {
        $expected = $this->createMock(DateTimeImmutable::class);
        $property = (new ReflectionClass(Bug::class))
            ->getProperty('createdAt');
        $this->bug->setCreatedAt($expected);
        $this->assertSame($expected, $property->getValue($this->bug));
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetUpdatedAt(): void
    {
        $expected = $this->createMock(DateTimeImmutable::class);
        $property = (new ReflectionClass(Bug::class))
            ->getProperty('updatedAt');
        $property->setValue($this->bug, $expected);
        $this->assertSame($expected, $this->bug->getUpdatedAt());
    }

    /**
     * @throws \ReflectionException
     */
    public function testSetUpdatedAt(): void
    {
        $expected = $this->createMock(DateTimeImmutable::class);
        $property = (new ReflectionClass(Bug::class))
            ->getProperty('updatedAt');
        $this->bug->setUpdatedAt($expected);
        $this->assertSame($expected, $property->getValue($this->bug));
    }

    public function testGetTitle(): void
    {
        $expected = '42';
        $property = (new ReflectionClass(Bug::class))
            ->getProperty('title');
        $property->setValue($this->bug, $expected);
        $this->assertSame($expected, $this->bug->getTitle());
    }

    /**
     * @throws \ReflectionException
     */
    public function testSetTitle(): void
    {
        $expected = '42';
        $property = (new ReflectionClass(Bug::class))
            ->getProperty('title');
        $this->bug->setTitle($expected);
        $this->assertSame($expected, $property->getValue($this->bug));
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetDescription(): void
    {
        $expected = '42';
        $property = (new ReflectionClass(Bug::class))
            ->getProperty('description');
        $property->setValue($this->bug, $expected);
        $this->assertSame($expected, $this->bug->getDescription());
    }

    /**
     * @throws \ReflectionException
     */
    public function testSetDescription(): void
    {
        $expected = '42';
        $property = (new ReflectionClass(Bug::class))
            ->getProperty('description');
        $this->bug->setDescription($expected);
        $this->assertSame($expected, $property->getValue($this->bug));
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetStatus(): void
    {
        $expected = true;
        $property = (new ReflectionClass(Bug::class))
            ->getProperty('status');
        $property->setValue($this->bug, $expected);
        $this->assertSame($expected, $this->bug->getStatus());
    }

    public function testSetStatus(): void
    {
        $expected = true;
        $property = (new ReflectionClass(Bug::class))
            ->getProperty('status');
        $this->bug->setStatus($expected);
        $this->assertSame($expected, $property->getValue($this->bug));
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetCategory(): void
    {
        $expected = $this->createMock(Category::class);
        $property = (new ReflectionClass(Bug::class))
            ->getProperty('category');
        $property->setValue($this->bug, $expected);
        $this->assertSame($expected, $this->bug->getCategory());
    }

    /**
     * @throws \ReflectionException
     */
    public function testSetCategory(): void
    {
        $expected = $this->createMock(Category::class);
        $property = (new ReflectionClass(Bug::class))
            ->getProperty('category');
        $this->bug->setCategory($expected);
        $this->assertSame($expected, $property->getValue($this->bug));
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetAuthor(): void
    {
        $expected = $this->createMock(User::class);
        $property = (new ReflectionClass(Bug::class))
            ->getProperty('author');
        $property->setValue($this->bug, $expected);
        $this->assertSame($expected, $this->bug->getAuthor());
    }

    /**
     * @throws \ReflectionException
     */
    public function testSetAuthor(): void
    {
        $expected = $this->createMock(User::class);
        $property = (new ReflectionClass(Bug::class))
            ->getProperty('author');
        $this->bug->setAuthor($expected);
        $this->assertSame($expected, $property->getValue($this->bug));
    }
}
