<?php

/**
 * User service.
 */

namespace App\Service;

use App\Interface\UserServiceInterface;
use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService implements UserServiceInterface
{
    public $userRepository;
    public $userPasswordHasher;
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
