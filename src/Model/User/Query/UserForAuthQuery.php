<?php

declare(strict_types=1);

namespace App\Model\User\Query;

use App\Model\User\Query\DTO\UserAuth;
use Doctrine\DBAL\Connection;

class UserForAuthQuery
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function fetch(string $email): ?UserAuth
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'email',
                'password_hash',
                'roles',
                'status'
            )
            ->from('users')
            ->where('email = :email')
            ->setParameter(':email', $email)
            ->execute()
            ->fetch();

        $stmt = ($stmt) ? new UserAuth(
            (int) $stmt['id'],
            $stmt['email'],
            $stmt['password_hash'],
            $stmt['roles'],
            $stmt['status']
        ) : null;

        return $stmt;
    }
}