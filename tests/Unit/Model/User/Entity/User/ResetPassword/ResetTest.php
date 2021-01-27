<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\User\Entity\User\ResetPassword;

use App\Model\User\Entity\User\ResetToken;
use App\Tests\Builder\User\UserBuilder;
use PHPUnit\Framework\TestCase;

class ResetTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = (new UserBuilder())->buildUserWithParam();
        $user->confirmSignUp();

        $now = new \DateTimeImmutable();
        $resetToken = new ResetToken('token', $now->modify('+1 day'));

        $user->requestPasswordReset($resetToken, $now);

        self::assertNotNull($user->getResetToken());

        $user->resetPassword($now, $newHash = 'new_hash');

        self::assertNull($user->getResetToken());
        self::assertEquals($newHash, $user->getPasswordHash());
    }

    public function testExpiredToken(): void
    {
        $user = (new UserBuilder())->buildUserWithParam();
        $user->confirmSignUp();

        $now = new \DateTimeImmutable();
        $resetToken = new ResetToken('token', $now);

        $user->requestPasswordReset($resetToken, $now);

        $this->expectExceptionMessage('Reset token is expired.');
        $user->resetPassword($now->modify('+1 day'), 'hash');
    }

    public function testNotRequested(): void
    {
        $user = (new UserBuilder())->buildUserWithParam();

        $now = new \DateTimeImmutable();

        $this->expectExceptionMessage('Resetting is already requested.');
        $user->resetPassword($now, 'hash');
    }
}