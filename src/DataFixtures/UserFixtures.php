<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture {

    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher) {

        $this->userPasswordHasher = $userPasswordHasher;
    }

    public const USER = 'Valentin';

    public function load(ObjectManager $manager): void {

         $user = new User();
         $user->setLogin("Valentin");
         $user->setPassword($this->userPasswordHasher->hashPassword($user, 'Valentin'));
         $user->setMail("mail.test@hotmail.fr");
         $user->setFirstname("Valentin");
         $user->setName("Lecavelier");
         $user->setRegistratedAt(date_create_immutable());
         $user->setRoles(["ROLE_USER"]);
         $user->setIsAcceptedTerms(1);
         $user->setToken(NULL);
         $user->setIsValid(1);
         $user->setAvatar("avatar-5");

         $manager->persist($user);
         $manager->flush();

        $this->addReference(self::USER, $user);
    }
}
