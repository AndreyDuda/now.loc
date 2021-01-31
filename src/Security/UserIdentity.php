<?php

declare(strict_types=1);

namespace App\Security;

use App\Model\User\Entity\User\User;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserIdentity implements UserInterface, EquatableInterface
{
    private int $id;
    private string $username;
    private string $password;
    private array $role;
    private string $status;

    public function __construct(
        int $id,
        string $username,
        string $password,
        array $role,
        string $status
    )
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
        $this->status = $status;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRoles(): array
    {
        return $this->role;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function eraseCredentials(): void
    {

    }

    public function isActive(): bool
    {
        return $this->status === User::STATUS_ACTIVE;
    }

    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof self) {
            return false;
        }

        return
            $this->id === $user->id &&
            $this->role === $user->role &&
            $this->status === $user->status;
    }
}