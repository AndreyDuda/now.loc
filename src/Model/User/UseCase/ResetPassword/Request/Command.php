<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\ResetPassword\Request;

use Symfony\Component\Validator\Constraint as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public string $email;
}