<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\User\Entity\User\SignUp;

use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\User;
use PHPUnit\Framework\TestCase;

class ConfirmTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = new User(
            $email = new Email('test@signup.test'),
            $hash = 'hash',
            $token = 'token'
        );

        $user->confirmSignUp();

        self::assertfalse($user->isWait());
        self::assertTrue($user->isActive());

        self::assertNull($user->getToken());
    }

    public function testAlready(): void
    {
        $user = new User(
            $email = new Email('test@signup.test'),
            $hash = 'hash',
            $token = 'token'
        );

        $user->confirmSignUp();
        $this->expectExceptionMessage('User is already confirmed');
        $user->confirmSignUp();
    }
}