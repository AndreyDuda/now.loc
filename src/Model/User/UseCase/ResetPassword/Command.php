<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\ResetPassword;

class Command
{
    public string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }
}