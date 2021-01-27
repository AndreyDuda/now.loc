<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\User\Entity\User\SignUp;

use App\Tests\Builder\User\UserBuilder;
use PHPUnit\Framework\TestCase;

class ConfirmTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = (new UserBuilder())->buildUserWithParam();

        $user->confirmSignUp();

        self::assertfalse($user->isWait());
        self::assertTrue($user->isActive());

        self::assertNull($user->getToken());
    }

    public function testAlready(): void
    {
        $user = (new UserBuilder())->buildUserWithParam();

        $user->confirmSignUp();
        $this->expectExceptionMessage('User is already confirmed');
        $user->confirmSignUp();
    }
}