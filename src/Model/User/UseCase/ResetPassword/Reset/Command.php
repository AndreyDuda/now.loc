<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\ResetPassword\Reset;

use Symfony\Component\Validator\Constraint as Assert;

class Command
{
    /**
     * @Assert\NotBlank
     */
    public string $token;
    /**
     * @Assert\NotBlank
     * @Assert\Length(min=4)
     */
    public string $password;

    public function __construct(string $token)
    {
        $this->token = $token;
    }


}