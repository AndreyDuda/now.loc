<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\ResetPassword\Request;

use App\Model\Flusher;
use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\User;
use App\Model\User\Repository\UserRepository;
use App\Model\User\Service\ResetTokenizer;
use App\Model\User\Service\ResetTokenSender;
use App\Model\User\Service\SignUpTokenizer;
use App\Model\User\Service\SignUpTokenSender;

class Handler
{
    private UserRepository $users;
    private Flusher $flusher;
    private ResetTokenizer $tokenizer;
    private ResetTokenSender $sender;

    public function __construct(
        UserRepository $users,
        Flusher $flusher,
        ResetTokenizer $tokenizer,
        ResetTokenSender $sender
    )
    {
        $this->users = $users;
        $this->flusher = $flusher;
        $this->tokenizer = $tokenizer;
        $this->sender = $sender;
    }

    public function handle(Command $command): void
    {
        /**
         * @todo query class
         * @var User $user
         */
        $user = $this->users->getByEmail(new Email($command->email));

        $user->requestPasswordReset(
            $this->tokenizer->generate(),
            new \DateTimeImmutable()
        );

        $this->flusher->flush();
        $this->sender->send($user->getEmail(), $user->getResetToken());
    }
}