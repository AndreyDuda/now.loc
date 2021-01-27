<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Role\Delete;

class Command
{
    public int $id;
    public string $role;

    public function __construct(int $id, string $role)
    {
        $this->id = $id;
        $this->role = $role;
    }
}