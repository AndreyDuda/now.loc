<?php

declare(strict_types=1);

namespace App\Tests\Builder\User;

use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\User;
use PHPUnit\Framework\TestCase;

class UserBuilder
{
    private \DateTimeImmutable $date;
    private Email $email;
    private string $hash;
    private string $token;

    public function buildUserWithParam(
        ?Email $email = null,
        ?string $hash = null,
        ?string $token = null
    ): User
    {
        $this->date = new \DateTimeImmutable();
        $this->email = ($email) ?? new Email('test@test.test');
        $this->hash = ($hash) ?? 'hash';
        $this->token = ($token) ?? 'token';

        return new User(
            $this->email,
            $this->hash,
            $this->token
        );
    }


}