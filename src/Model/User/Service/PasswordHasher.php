<?php

declare(strict_types=1);

namespace App\Model\User\Service;

class PasswordHasher
{
    public function hash(string $password): string
    {
        if (false === $hash = password_hash($password, PASSWORD_ARGON2I)) {
            throw new \RuntimeException('Unable to generate.');
        }
        return $hash;
    }

    public function validate(string $password, string $hash)
    {
        return password_verify($password, $hash);
    }
}