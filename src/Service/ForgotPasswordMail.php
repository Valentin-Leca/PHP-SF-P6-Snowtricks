<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class ForgotPasswordMail {

    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer) {

        $this->mailer = $mailer;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendForgotPAsswordMail($user): void {

        $email = (new TemplatedEmail())
            ->from('testmailsymfonymailer@gmail.com')
            ->to($user->getMail())
            ->subject('Snowtricks - Réinitialisation de mot de passe !')
            ->text('Sending emails is fun again!')
            ->htmlTemplate('emails/forgotPassword.html.twig')
            ->context(['mailAdress' => $user->getMail(),
                'login' => $user->getLogin(),
                'token' => $user->getToken(),
            ]);

        $this->mailer->send($email);
    }

}