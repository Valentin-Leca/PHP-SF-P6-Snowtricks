<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class RegisterMail {

    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer) {

        $this->mailer = $mailer;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendRegisterMail(User $user): void {

        $email = (new TemplatedEmail())
            ->from('testmailsymfonymailer@gmail.com')
            ->to($user->getMail())
            ->subject('Bienvenue sur Snowtricks !')
            ->text('Sending emails is fun again!')
            ->htmlTemplate('emails/createAccount.html.twig')
            ->context(['mailAdress' => $user->getMail(),
                'login' => $user->getLogin(),
                'token' => $user->getToken(),
            ]);

        $this->mailer->send($email);
    }

}
