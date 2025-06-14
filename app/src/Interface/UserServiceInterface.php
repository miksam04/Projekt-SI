<?php

/**
 * User interface.
 */

namespace App\Interface;

use App\Entity\User;

/**
 * Interface UserServiceInterface.
 *
 * Provides methods to manage user data.
 */
interface UserServiceInterface
{
    /**
     * Get user by ID.
     *
     * @param int $id User ID
     *
     * @return User|null User object or null if not found
     */
    public function getUserById(int $id): ?User;

    /**
     * Save user.
     *
     * @param User $user User object to save
     */
    public function saveUser(User $user): void;

    /**
     * Update user password.
     *
     * @param User   $user          User object
     * @param string $plainPassword Plain text password to set
     */

    /**
     * Update user password.
     *
     * @param User        $user          User object
     * @param string|null $plainPassword Plain text password to set, or null to remove password
     */
    public function updatePassword(User $user, ?string $plainPassword): void;

    /**
     * Check if a permission can be removed.
     *
     * @param User $user User object
     *
     * @return bool True if the permission can be removed, false otherwise
     */
    public function canAdminBeRemoved(User $user): bool;

    /**
     * Check if a user can be blocked.
     *
     * @param User $user User object
     *
     * @return bool True if the user can be blocked, false otherwise
     */
    public function canBeBlocked(User $user): bool;
}
