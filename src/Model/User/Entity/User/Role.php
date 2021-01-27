<?php

namespace App\Model\User\Entity\User;

class Role
{
    public const USER = 'ROLE_USER';
    public const ADMIN = 'ROLE_ADMIN';

    public static function checkAvailableRoles(string $role): bool
    {
        $availableRoles = [
            self::USER,
            self::ADMIN,
        ];

        return in_array($role, $availableRoles);
    }
}