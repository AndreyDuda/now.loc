<?php

declare(strict_types=1);

namespace App\Model\User\Query\DTO;

class UserAuth
{
    public int $id;
    public string $email;
    public string $passwordHash;
    public string $roles;
    public string $status;

    public function __construct(
        int $id,
        string $email,
        string $passwordHash,
        string $roles,
        string $status
    )
    {
        $this->id = $id;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->roles = $roles;
        $this->status = $status;
    }


}