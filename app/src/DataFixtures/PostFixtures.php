<?php

/**
 * Post fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use App\Entity\Category;

/**
 * Class PostFixtures.
 *
 * This class is responsible for loading the initial data into the database.
 */
class PostFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * Load the fixtures.
     *
     * @param ObjectManager $manager The object manager
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $categories = $categories = $manager->getRepository(Category::class)->findAll();


        $author = $this->getReference('admin', User::class);

        if (!$author) {
            throw new \Exception('Author not found');
        }

        for ($i = 0; $i < 30; ++$i) {
            $post = new Post();
            $post->setTitle($faker->sentence(6, true));
            $post->setContent($faker->paragraph(3, true));
            $post->setAuthor($author);
            $post->setCategory($categories[array_rand($categories)]);

            $manager->persist($post);
        }

        $manager->flush();
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
        ];
    }
}
