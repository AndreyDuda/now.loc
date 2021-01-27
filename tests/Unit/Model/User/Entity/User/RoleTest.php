<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\User\Entity\User;

use App\Model\User\Entity\User\Role;
use App\Tests\Builder\User\UserBuilder;
use PHPUnit\Framework\TestCase;

class RoleTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = (new UserBuilder())->buildUserWithParam();

        $user->addRole(Role::ADMIN);
        self::assertTrue($user->hasRole(Role::ADMIN));
        self::assertTrue($user->hasRole(Role::USER));

        $user->deleteRole(Role::ADMIN);
        self::assertFalse($user->hasRole(Role::ADMIN));
        self::assertTrue($user->hasRole(Role::USER));
    }

    public function testAlready(): void
    {
        $user = (new UserBuilder())->buildUserWithParam();

        $this->expectExceptionMessage('Role is already same.');
        $user->addRole(Role::USER);
    }
}