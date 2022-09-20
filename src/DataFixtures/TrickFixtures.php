<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\AsciiSlugger;

class TrickFixtures extends Fixture implements DependentFixtureInterface {

    public function load(ObjectManager $manager): void {

        $trickNameGrabs = ['Mute', 'Sad', 'Indy', 'Stalefish', 'Tail Grab', 'Nose Grab', 'Japan Air', 'Seat Belt', 'Truck Driver'];
        $trickNameRotations = ['180', '360', '540', '720', '900', '1080'];
        $trickNameFlips = ['Front-Flip', 'Back-Flip'];
        $trickNameSlides = ['Shifty', 'Spray', 'Slide'];
        $trickContent = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas mollis condimentum pharetra.
         Pellentesque sit amet sapien finibus, laoreet augue iaculis, porttitor ipsum. Aliquam non dictum mi.
         Donec id dui iaculis, dictum odio eu, semper libero. Phasellus felis velit, ultrices ac placerat sed, tristique id odio.
         Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Duis gravida neque felis,
         a laoreet ex maximus ut. Sed pharetra lectus vel tortor iaculis viverra. Curabitur elit lacus, tempus quis
         suscipit eu, semper sollicitudin diam. Nullam consequat nec orci sit amet tempus. Nam in diam feugiat lacus
         ultricies dapibus vitae nec lectus. Donec enim justo, posuere non ante rutrum, tempor porta tortor.
         Maecenas non diam lectus. Curabitur vehicula rutrum elit ac euismod. Quisque mattis mauris quam, et tempor metus maximus et.

         Aliquam erat volutpat. Phasellus at massa iaculis, fringilla tortor id, posuere purus. Suspendisse pharetra elit
         et sem aliquet hendrerit. Sed non lacus convallis, tempor nunc in, ornare libero. Aenean et erat et arcu maximus
         dignissim. Mauris est ipsum, malesuada at eleifend vel, bibendum et eros. Donec sed sagittis arcu. Duis mattis
         nibh in leo placerat posuere. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
         Etiam pulvinar, enim eu tristique scelerisque, ante velit tempor eros, ut imperdiet ipsum felis sit amet massa.
         Praesent mollis luctus iaculis. Nunc sollicitudin nibh id nunc fringilla, vitae finibus libero dapibus.
         Praesent dapibus pharetra sollicitudin. In leo neque, vestibulum non tellus quis, tempus congue diam. Vivamus sodales
         pretium leo, nec egestas ipsum suscipit id.

         Mauris egestas turpis lacinia, tincidunt eros sit amet, tincidunt diam. Nam ante turpis, pellentesque vitae vulputate
         ut, vestibulum nec felis. Vestibulum urna diam, accumsan vitae convallis vitae, vehicula sed libero. Vestibulum finibus,
         sem et porta venenatis, nisi est porttitor neque, et vestibulum sapien nunc et neque. Maecenas congue, turpis
         eget tempor eleifend, ex ante eleifend ex, at efficitur neque justo sed diam. Ut suscipit tincidunt enim, nec imperdiet
         ligula condimentum in. Aliquam at venenatis mauris, sed luctus risus.";

        foreach($trickNameGrabs as $grab) {
            $trick = new Trick();
            $trick->setName($grab);
            $trick->setContent($trickContent);
            $slugger = new AsciiSlugger();
            $slug = $slugger->slug($trick->getName());
            $trick->setSlug(strtolower($slug));
            $trick->setUser($this->getReference(UserFixtures::USER));
            $trick->setGrouptrick($this->getReference(GroupFixtures::GROUP));
            $manager->persist($trick);
        }

        $manager->flush();
    }

    public function getDependencies() {

        return [
            GroupFixtures::class,
            UserFixtures::class,
        ];
    }
}
