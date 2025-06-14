<?php

/**
 * User service.
 */

namespace App\Service;

use App\Interface\UserServiceInterface;
use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class UserService.
 *
 * Provides methods to manage user data.
 */
class UserService implements UserServiceInterface
{
    public $security;
    public $paginator;
    public $userRepository;
    public $userPasswordHasher;
    private const ITEMS_PER_PAGE = 10;

    /**
     * UserService constructor.
     *
     * @param UserRepository              $userRepository     User repository
     * @param UserPasswordHasherInterface $userPasswordHasher Password hasher
     * @param PaginatorInterface          $paginator          Paginator service
     * @param Security                    $security           Security service
     */
    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher, PaginatorInterface $paginator, Security $security)
    {
        $this->userRepository = $userRepository;
        $this->userPasswordHasher = $userPasswordHasher;
        $this->paginator = $paginator;
        $this->security = $security;
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

    /**
     * Get paginated users.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface Paginated list of users
     */
    public function getPaginatedUsers(int $page): PaginationInterface
    {
        $query = $this->userRepository->queryAll();

        return $this->paginator->paginate($query, $page, self::ITEMS_PER_PAGE);
    }

    /**
     * Check if an admin can be removed.
     *
     * @param User $user User object to check
     *
     * @return bool True if the admin can be removed, false otherwise
     */
    public function canAdminBeRemoved(User $user): bool
    {
        $admins = $this->userRepository->findByRole('ROLE_ADMIN');

        $wasAdmin = false;
        foreach ($admins as $admin) {
            if ($admin->getId() === $user->getId()) {
                $wasAdmin = true;
                break;
            }
        }

        return !($wasAdmin && !in_array('ROLE_ADMIN', $user->getRoles(), true) && 1 === count($admins));
    }

    /**
     * Check if a user can be blocked.
     *
     * @param User $user User object to check
     *
     * @return bool True if the user can be blocked, false otherwise
     */
    public function canBeBlocked(User $user): bool
    {
        $currentUser = $this->security->getUser();

        return !($currentUser && $user->getId() === $currentUser->getId() && $user->isBlocked());
    }
}
