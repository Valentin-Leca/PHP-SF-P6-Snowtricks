<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface {


    public function checkPreAuth(UserInterface $user): void {

    }

    public function checkPostAuth(UserInterface $user): void
    {

        if (!$user instanceof User) {
            return;
        }
        if (!$user->isIsValid()) {
            throw new CustomUserMessageAccountStatusException("Vous ne pouvez pas vous connecter car vous
             n'avez pas encore validé votre compte via le mail d'inscription.");
        }
    }
}
