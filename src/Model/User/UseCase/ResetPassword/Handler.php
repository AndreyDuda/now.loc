<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\ResetPassword;

use App\Model\Flusher;
use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\User;
use App\Model\User\Repository\UserRepository;
use App\Model\User\Service\SignUpTokenizer;
use App\Model\User\Service\SignUpTokenSender;

class Handler
{
    private UserRepository $users;
    private Flusher $flusher;
    private SignUpTokenizer $tokenizer;
    private SignUpTokenSender $sender;

    public function __construct(
        UserRepository $users,
        Flusher $flusher,
        SignUpTokenizer $tokenizer,
        SignUpTokenSender $sender
    )
    {
        $this->users = $users;
        $this->flusher = $flusher;
        $this->tokenizer = $tokenizer;
        $this->sender = $sender;
    }

    public function handle(Command $command): void
    {
        /** @var User $user */
        $user = $this->users->getByEmail(new Email($command->email));

        $user->requestPasswordReset(
            $this->tokenizer->generate(),
            new \DateTimeImmutable()
        );

        $this->flusher->flush();
        $this->sender->send($user->getEmail(), $user->getResetToken());
    }
}