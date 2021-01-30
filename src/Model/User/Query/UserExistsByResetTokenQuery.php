<?php

declare(strict_types=1);

namespace App\Model\User\Query;

use Doctrine\DBAL\Connection;

class UserExistsByResetTokenQuery
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function fetch(string $token): bool
    {
        return $this->connection->createQueryBuilder()
            ->select('COUNT (*)')
            ->from('users')
            ->where('reset_token_token = :token')
            ->setParameter(':token', $token)
            ->execute()
            ->fetchOne() > 0;
    }
}