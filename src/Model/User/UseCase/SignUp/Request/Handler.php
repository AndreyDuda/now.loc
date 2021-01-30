<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\SignUp\Request;

use App\Model\Flusher;
use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\User;
use App\Model\User\Repository\UserRepository;
use App\Model\User\Service\PasswordHasher;
use App\Model\User\Service\SignUpTokenizer;
use App\Model\User\Service\SignUpTokenSender;
use Doctrine\ORM\EntityManagerInterface;

class Handler
{
    private EntityManagerInterface $em;
    private PasswordHasher $hasher;
    private UserRepository $users;
    private SignUpTokenizer $tokenizer;
    private SignUpTokenSender $sender;
    private Flusher $flusher;

    public function __construct(
        EntityManagerInterface $em,
        PasswordHasher $hasher,
        UserRepository $users,
        SignUpTokenizer $tokenizer,
        SignUpTokenSender $sender,
        Flusher $flusher
    )
    {
        $this->em = $em;
        $this->hasher = $hasher;
        $this->users = $users;
        $this->tokenizer = $tokenizer;
        $this->sender = $sender;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $email = new Email($command->email);

        if ($this->users->hasByEmail($email)) {
            throw new \DomainException('User already exists.');
        }

        $user = new User(
            $email,
            $this->hasher->hash($command->password),
            $token = $this->tokenizer->generate()
        );

        $this->users->add($user);
        $this->sender->send($email, $token);
        $this->flusher->flush();
    }
}