<?php

namespace App\Service\Handler;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFormHandler {

    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $hasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher) {

        $this->entityManager = $entityManager;
        $this->hasher = $hasher;
    }

    public function setAndFlushUserForm(User $user, object $form): void {

        if (!empty($form->getData()['password'])) {
            $user->setPassword($this->hasher->hashPassword($user, $form->getData()['password']));
        }

        $user->setName($form->getData()['name']);
        $user->setFirstname($form->getData()['firstname']);
        $user->setMail($form->getData()['mail']);
        $user->setAvatar($form->getData()['avatar']);
        $this->entityManager->flush($user);

    }

}
