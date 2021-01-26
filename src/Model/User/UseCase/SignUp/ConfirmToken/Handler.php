<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\SignUp\ConfirmToken;

use App\Model\Flusher;
use App\Model\User\Repository\UserRepository;

class Handler
{
    private UserRepository $users;
    private Flusher $flusher;

    public function __construct(UserRepository $users, Flusher $flusher)
    {
        $this->users = $users;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        /**@todo query class */
        if (!$user = $this->users->findByToken($command->token)) {
            throw new \DomainException('Incorrect or confirmed token');
        }

        $user->confirmSignUp();

        $this->flusher->flush();
    }
}