<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\ResetPassword\Reset;

use App\Model\Flusher;
use App\Model\User\Entity\User\User;
use App\Model\User\Repository\UserRepository;
use App\Model\User\Service\PasswordHasher;

class Handler
{
    private UserRepository $users;
    private PasswordHasher $hasher;
    private Flusher $flusher;

    public function __construct(UserRepository $users, PasswordHasher $hasher, Flusher $flusher)
    {
        $this->users = $users;
        $this->hasher = $hasher;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        /**@todo class Query
         * @var User $user
         */
        if (!$user = $this->users->findByResetToken($command->token)) {
            throw new \DomainException('Incorrect or confirmed token.');
        }

        $user->resetPassword(
            new \DateTimeImmutable(),
            $this->hasher->hash($command->password)
        );

        $this->flusher->flush();
    }


}