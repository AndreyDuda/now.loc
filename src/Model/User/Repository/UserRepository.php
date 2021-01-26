<?php

declare(strict_types=1);

namespace App\Model\User\Repository;

use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\User;

interface UserRepository
{
    public function create(Email $email, string $hash): void;
    public function add(User $user): void;
}