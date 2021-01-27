<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

use phpDocumentor\Reflection\Types\Integer;
use PHPUnit\Util\Json;

class User
{
    private const STATUS_WAIT = 'wait';
    private const STATUS_ACTIVE = 'active';

    private int $id;
    private Email $email;
    private string $passwordHash;
    private ?string $token;
    private \DateTimeImmutable $date;
    private string $status;
    private ?ResetToken $resetToken;
    private array $roles;

    public function __construct(Email $email, string $passwordHash, string $token)
    {
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->token = $token;
        $this->date = new \DateTimeImmutable();
        $this->status = self::STATUS_WAIT;
        $this->resetToken = null;
        $this->roles[] = Role::USER;
    }

    public function addRole(string $role): void
    {
        if (!Role::checkAvailableRoles($role)) {
            throw new \DomainException('Role is not available.');
        }
        if (in_array($role, $this->roles)) {
            throw new \DomainException('Role is already same.');
        }
        $this->roles[] = $role;
    }

    public function deleteRole(string $role): void
    {
        if (!Role::checkAvailableRoles($role) || !in_array($role, $this->roles)) {
            throw new \DomainException('Role is not available');
        }

        $keyRole = array_search($role, $this->roles);
        unset($this->roles[$keyRole]);
    }

    public function confirmSignUp(): void
    {
        if (!$this->isWait()) {
            throw new \DomainException('User is already confirmed.');
        }
        $this->status = self::STATUS_ACTIVE;
        $this->token = null;
    }

    public function requestPasswordReset(ResetToken $token, \DateTimeImmutable $date): void
    {
        if (!$this->isActive()) {
            throw new \DomainException('User is not active.');
        }
        if ($this->resetToken && !$this->resetToken->isExpiredTo($date)) {
            throw new \DomainException('Resetting is already requested.');
        }
        $this->resetToken = $token;
    }

    public function resetPassword(\DateTimeImmutable $date, string $hash): void
    {
        if (!$this->resetToken) {
            throw new \DomainException('Resetting is already requested.');
        }
        if ($this->resetToken->isExpiredTo($date)) {
            throw new \DomainException('Reset token is expired.');
        }
        $this->passwordHash = $hash;
        $this->resetToken = null;
    }

    public function isWait(): bool
    {
        return $this->getStatus() === self::STATUS_WAIT;
    }

    public function isActive(): bool
    {
        return $this->getStatus() === self::STATUS_ACTIVE;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getResetToken(): ?ResetToken
    {
        return $this->resetToken;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function hasRole(string $role): bool
    {
        return in_array($role, $this->roles);
    }
}