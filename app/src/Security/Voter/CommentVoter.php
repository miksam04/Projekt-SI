<?php

/**
 * Post voter.
 */

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Comment;

final class CommentVoter extends Voter
{
    public const DELETE = 'COMMENT_DELETE';
    public const CREATE = 'COMMENT_CREATE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::DELETE, self::CREATE])
            && $subject instanceof Comment;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }
        if (!$subject instanceof Comment) {
            return false;
        }

        return match ($attribute) {
            self::DELETE => $this->canDelete($subject, $user),
            self::CREATE => $this->canCreate($subject, $user),
            default => false,
        };
    }

    private function canDelete(Comment $comment, UserInterface $user): bool
    {
        return $user->hasRole('ROLE_ADMIN');
    }

    private function canCreate(Comment $comment, UserInterface $user): bool
    {
        return $user->hasRole('ROLE_USER') || $user->hasRole('ROLE_ADMIN');
    }
}
