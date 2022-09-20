<?php

namespace App\DataFixtures;

use App\Entity\Group;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GroupFixtures extends Fixture {

    public const GROUP = 'TrickGroup';

    public function load(ObjectManager $manager): void {

        $groupName = ['Grabs', 'Rotations', 'Flips', 'Slides'];

        foreach($groupName as $name) {
            $group = new Group();
            $group->setName($name);
            $manager->persist($group);
        }
        $manager->flush();
        $this->addReference(self::GROUP, $group);
    }
}
