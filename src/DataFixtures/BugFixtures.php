<?php

/**
 * bug fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Bug;
use App\Entity\Category;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class bugFixtures.
 */
class BugFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullPropertyFetch
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        if (null === $this->manager || null === $this->faker) {
            return;
        }

        $this->createMany(100, 'bugs', function (int $i) {
            $bug = new bug();
            $bug->setTitle($this->faker->sentence);
            $bug->setCreatedAt(
                DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );
            $bug->setUpdatedAt(
                DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );
            $bug->setDescription($this->faker->sentence);
            $bug->setStatus($this->faker->boolean());
            /** @var Category $category */
            $category = $this->getRandomReference('categories');
            $bug->setCategory($category);

            /** @var User $author */
            $author = $this->getRandomReference('admins');
            $bug->setAuthor($author);

            return $bug;
        });

        $this->manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return string[] of dependencies
     *
     * @psalm-return array{0: CategoryFixtures::class}
     */
    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }
}
