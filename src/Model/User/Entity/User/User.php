<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

use phpDocumentor\Reflection\Types\Integer;

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

    public function __construct(Email $email, string $passwordHash, string $token)
    {
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->token = $token;
        $this->date = new \DateTimeImmutable();
        $this->status = self::STATUS_WAIT;
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
        if ($this->resetToken && !$this->resetToken->isExpiredTo($date)) {
            throw new \DomainException('Resetting is already requested.');
        }
        $this->resetToken = $token;
    }

    public function resetPassword(\DateTimeImmutable $date, ResetToken $token): void
    {

    }

    public function isWait(): bool
    {
        return $this->getStatus() === self::STATUS_WAIT;
    }

    public function isActive(): bool
    {
        return $this->getStatus() === self::STATUS_ACTIVE;
    }
}