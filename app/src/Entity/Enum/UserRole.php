<?php

/**
 * UserRole enum class.
 */

namespace App\Entity\Enum;

enum UserRole: string
{
    case ROLE_ADMIN = 'ROLE_ADMIN';
    case ROLE_USER = 'ROLE_USER';

    public function label(): string
    {
        return match ($this) {
            UserRole::ROLE_ADMIN => 'role_admin',
            Userrole::ROLE_USER => 'role_user',
        };
    }
}
