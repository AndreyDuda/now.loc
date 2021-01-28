<?php

declare(strict_types=1);

namespace App\Model\User\Repository;

use App\Exception\NotFoundException;
use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class UserRepository
{
    private EntityManagerInterface $em;
    private ObjectRepository $rep;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->rep = $em->getRepository(User::class);
    }

    public function findByToken(string $token): ?User
    {
        return $this->rep->findOneBy(['token' => $token]);
    }

    public function findByResetToken(string $token): ?User
    {
        return $this->rep->findOneBy(['resetToken.token' => $token]);
    }

    public function get(int $id): User
    {
        /** @var User $user */
        if (!$user = $this->rep->find($id->getValue())) {
            throw new NotFoundException('User is not found.');
        }
        return $user;
    }

    public function getByEmail(Email $email): User
    {
        /** @var User $user */
        if (!$user = $this->rep->findOneBy(['email' => $email->getValue()])) {
            throw new NotFoundException('User is not found.');
        }
        return $user;
    }

    public function hasByEmail(Email $email): bool
    {
        return $this->rep->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.email = :email')
                ->setParameter(':email', $email->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function add(User $user): void
    {
        $this->em->persist($user);
    }
}