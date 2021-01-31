<?php

declare(strict_types=1);

namespace App\Model\User\Query\DTO;

class UserAuth
{
    public int $id;
    public string $email;
    public string $passwordHash;
    public array $role;
    public string $status;

    public function __construct(
        int $id,
        string $email,
        string $passwordHash,
        array $role,
        string $status
    )
    {
        $this->id = $id;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->role = $role;
        $this->status = $status;
    }


}