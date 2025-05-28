<?php

/**
 * Post fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;

/**
 * Class PostFixtures.
 *
 * This class is responsible for loading the initial data into the database.
 */
class PostFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load the fixtures.
     */
    public function loadData(): void
    {
        if (!$this->manager instanceof ObjectManager || !$this->faker instanceof Generator) {
            return;
        }

        $this->createMany(15, 'post', function (int $i) {
            $post = new Post();
            $post->setTitle($this->faker->sentence());
            $post->setContent($this->faker->paragraphs(3, true));
            $post->setAuthor($this->getRandomReference('user', User::class));
            $post->setCategory($this->getRandomReference('category', Category::class));

            return $post;
        });
    }

    /**
     * Get the dependencies.
     *
     * @return array The dependencies
     */
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
