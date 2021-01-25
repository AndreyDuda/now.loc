<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

class User
{
    /** @var string  */
    private string $email;
    /** @var string  */
    private string $passwordHash;

    public function __construct(string $email, string $passwordhash)
    {
        $this->email = $email;
        $this->passwordHash = $passwordhash;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }
}