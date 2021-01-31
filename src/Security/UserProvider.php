<?php

declare(strict_types=1);

namespace App\Security;

use App\Model\User\Query\DTO\UserAuth;
use App\Model\User\Query\UserForAuthQuery;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    private UserForAuthQuery $users;

    public function __construct(UserForAuthQuery $users)
    {
        $this->users = $users;
    }

    public function loadUserByUsername(string $username): UserInterface
    {
        $user = $this->loadUser($username);
        return self::identityByUser($user);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof UserIdentity) {
            throw new UnsupportedUserException('Invalid user class ' . get_class($user));
        }

        $user = $this->loadUser($user->getUsername());
        return self::identityByUser($user);
    }

    public function supportsClass(string $class): bool
    {
        return $class instanceof UserIdentity;
    }

    public static function identityByUser(UserAuth $user): UserIdentity
    {
        return new UserIdentity(
            $user->id,
            $user->email,
            $user->passwordHash,
            $user->role,
            $user->status
        );
    }

    public function loadUser($username)
    {
        if (!$user = $this->users->fetch($username)) {
            throw new UsernameNotFoundException('');
        }

        return $user;
    }
}