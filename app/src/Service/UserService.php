<?php

/**
 * User service.
 */

namespace App\Service;

use App\Interface\UserServiceInterface;
use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class UserService.
 *
 * Provides methods to manage user data.
 */
class UserService implements UserServiceInterface
{
    public $userRepository;
    public $userPasswordHasher;

    /**
     * UserService constructor.
     *
     * @param UserRepository              $userRepository     User repository
     * @param UserPasswordHasherInterface $userPasswordHasher Password hasher
     */
    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userRepository = $userRepository;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    /**
     * Get user by ID.
     *
     * @param int $id User ID
     *
     * @return User|null User object or null if not found
     */
    public function getUserById(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    /**
     * Delete user.
     *
     * @param User $user User object to delete
     */
    public function saveUser(User $user): void
    {
        $this->userRepository->saveUser($user);
    }

    /**
     * Update user password.
     *
     * @param User        $user          User object
     * @param string|null $plainPassword Plain text password to hash and set
     *
     * @throws \RuntimeException If password hashing fails
     */
    public function updatePassword(User $user, ?string $plainPassword): void
    {
        if ($plainPassword) {
            $hashedPassword = $this->userPasswordHasher->hashPassword($user, $plainPassword);
            if (false === $hashedPassword) {
                throw new \RuntimeException('Failed to hash password');
            }
            $user->setPassword($hashedPassword);
        }
    }
}
