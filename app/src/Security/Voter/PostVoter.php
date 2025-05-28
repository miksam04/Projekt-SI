<?php

/**
 * Post voter.
 */

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Post;

final class PostVoter extends Voter
{
    public const DELETE = 'POST_DELETE';
    public const EDIT = 'POST_EDIT';
    public const CREATE = 'POST_CREATE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::DELETE, self::CREATE])
            && $subject instanceof Post;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }
        if (!$subject instanceof Post) {
            return false;
        }

        return match ($attribute) {
            self::EDIT => $this->canEdit($subject, $user),
            self::DELETE => $this->canDelete($subject, $user),
            self::CREATE => $this->canCreate($user),
            default => false,
        };
    }

    private function canDelete(Post $post, UserInterface $user): bool
    {
        return $post->getAuthor() === $user || $user->hasRole('ROLE_ADMIN');
    }

    private function canEdit(Post $post, UserInterface $user): bool
    {
        return $post->getAuthor() === $user;
    }

    private function canCreate(UserInterface $user): bool
    {
        return $user->hasRole('ROLE_ADMIN');
    }
}
