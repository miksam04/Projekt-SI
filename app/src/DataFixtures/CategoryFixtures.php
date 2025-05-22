<?php

/**
 * Category fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Class CategoryFixtures.
 *
 * This class is responsible for loading the initial data into the database.
 */
class CategoryFixtures extends Fixture
{
    /**
     * Load the fixtures into the database.
     *
     * @param ObjectManager $manager The object manager
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $categoriesCount = 10;

        for ($i = 0; $i < $categoriesCount; ++$i) {
            $category = new Category();
            $category->setName($faker->unique()->word());
            $category->setSlug($category->getName());

            $manager->persist($category);
        }

        $manager->flush();
    }
}
