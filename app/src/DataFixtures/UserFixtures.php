<?php

/**
 * User fixtures.
 */

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class UserFixtures.
 *
 * This class is responsible for loading the initial data into the database.
 */
class UserFixtures extends Fixture
{
    /**
     * UserFixtures constructor.
     *
     * @param UserPasswordHasherInterface $passwordHasher The password hasher
     */
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    /**
     * Load the fixtures into the database.
     *
     * @param ObjectManager $manager The object manager
     */
    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@example.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword($admin, 'twojeHaslo123');
        $admin->setPassword($hashedPassword);
        $admin->setNickname('Admin');

        $this->addReference('admin', $admin);

        $manager->persist($admin);
        $manager->flush();
    }
}
