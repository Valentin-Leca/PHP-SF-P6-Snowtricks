<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture {

    public const USER = 'Valentin';

    public function load(ObjectManager $manager): void {

         $user = new User();
         $user->setLogin("Valentin");
         $user->setPassword("$2y$13\$tuGbSrJpNflNfunXwy1TaOielZ4ZqJhPoQGrd4C9ieMJMgt2Iwkha");
         $user->setMail("valentin.val78@hotmail.fr");
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
