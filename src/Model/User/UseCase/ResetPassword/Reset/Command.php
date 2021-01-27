<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\ResetPassword\Reset;

class Command
{
    public string $token;
    public string $password;

    public function __construct(string $token, string $password)
    {
        $this->token = $token;
        $this->password = $password;
    }


}