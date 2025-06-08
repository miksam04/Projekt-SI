<?php

/**
 * User checker.
 */

namespace App\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use App\Entity\User;

/**
 * Class UserChecker.
 *
 * This class checks user account status before authentication.
 */
class UserChecker implements UserCheckerInterface
{
    /**
     * Check pre-authentication user status.
     *
     * @param UserInterface $user the user to check
     *
     * @return void returns nothing
     *
     * @throws CustomUserMessageAccountStatusException if the user is not enabled
     */
    public function checkPreAuth(UserInterface $user): void
    {
        if ($user instanceof User && $user->isBlocked()) {
            throw new CustomUserMessageAccountStatusException('Your account is blocked.');
        }
    }

    /**
     * Check post-authentication user status.
     *
     * @param UserInterface $user the user to check
     *
     * @return void returns nothing
     */
    public function checkPostAuth(UserInterface $user): void
    {
        // No post-authentication checks needed in this implementation.
    }
}
