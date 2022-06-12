<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class UserEventSubscriber implements EventSubscriberInterface {

    // Exemple non utilisé dans le code

    public function onLogin(AuthenticationSuccessEvent $event) {

        $user = $event->getAuthenticationToken()->getUser();

        if (!$user instanceof User) {
            return;
        }
        if ($user->isIsValid()) {
            return;
        }
        throw new AuthenticationException();
    }

    public static function getSubscribedEvents(): array {

        return [
            AuthenticationSuccessEvent::class => ['onLogin', 256],
        ];
    }
}
