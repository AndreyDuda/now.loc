<?php

declare(strict_types=1);

namespace App\Model\User\Service;

use App\Model\User\Entity\User\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Twig\Environment;

class SignUpTokenSender
{
    private MailerInterface $mailer;
    private Environment $twig;
    private string $from;

    public function __construct(MailerInterface $mailer, Environment $twig, string $from)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->from = $from;
    }


    public function send(Email $email, string $token): void
    {
        $message = (new TemplatedEmail())
            ->from($this->from)
            ->to(new Address($email->getValue()))
            ->subject('sign Up Confirmed')
            ->htmlTemplate('mail/user/signup.html.twig')
            ->context([
                'token' => $token
            ]);

        $this->mailer->send($message);
    }
}