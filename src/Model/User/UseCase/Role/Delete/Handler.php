<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Role\Delete;

use App\Model\Flusher;
use App\Model\User\Entity\User\User;
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

    public function handle(Command $command)
    {
        /**
         * @var User $user
         * @todo Class Query
         */
        $user = $this->users->getById($command->id);

        $user->deleteRole($command->role);

        $this->flusher->flush();
    }
}