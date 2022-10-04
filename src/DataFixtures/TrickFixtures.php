<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
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
        $comments = ['Super, j\'adore cette figure !', 'Vivement la prochaine !', 'Trop difficile à faire celle-ci ^_^'];
        $videoLinks = ['https://www.youtube.com/watch?v=arzLq-47QFA', 'https://www.youtube.com/watch?v=eGJ8keB1-JM',
            'https://www.youtube.com/watch?v=BVeAbNIHktE'];
        $trickContent = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vel purus id nulla pulvinar dapibus.
        Nam dui lectus, lobortis sit amet magna et, faucibus hendrerit mi. Vestibulum ante ipsum primis in
        faucibus orci luctus et ultrices posuere cubilia curae; Pellentesque placerat, massa sit amet rutrum viverra, 
        velit ipsum varius mauris, eu ultrices urna nisl aliquet justo. Ut placerat enim enim, ac ullamcorper 
        nisi efficitur vel. Praesent interdum velit eget libero commodo, dapibus fringilla est tempus. Praesent vitae 
        orci sed dolor gravida accumsan a ut lorem. In ornare turpis vitae sem rhoncus, id ullamcorper nunc viverra. 
        In sagittis arcu eu purus commodo ultricies. Donec quis molestie ex. Sed turpis elit, vestibulum quis vulputate
        a, aliquam eu arcu. Mauris dapibus lacus sit amet euismod pretium. Donec sodales, tellus eget venenatis
        pharetra, nibh quam fermentum lorem, at mattis erat metus sed neque. Vestibulum ac euismod est, sed
        sollicitudin nunc. In rhoncus fringilla nisl, a tincidunt diam mattis ac. Nunc dui felis, euismod a scelerisque
        et, consectetur eu sem.";

        foreach($trickNameGrabs as $grab) {
            $trick = new Trick();
            $trick->setName($grab);
            $trick->setContent($trickContent);
            $slugger = new AsciiSlugger();
            $slug = $slugger->slug($trick->getName());
            $trick->setSlug(strtolower($slug));
            $trick->setUser($this->getReference(UserFixtures::USER));
            $trick->setGrouptrick($this->getReference("TrickGroup0"));

            for($i = 1; $i < 4; $i++) {
                $image = new Image();
                $image->setImagename("Snowboard-".rand(1, 3).".jpg");
                $image->setTricksId($trick);
                $image->setFile(NULL);
                $manager->persist($image);
            }

            for($i = 0; $i < 3; $i++) {
                $video = new Video();
                $video->setVideoname($videoLinks[$i]);
                $video->setVideoId(substr($videoLinks[$i], 32, 11));
                $video->setTrickId($trick);
                $manager->persist($video);
            }

            for($i = 0; $i < 3; $i++) {
                $comment = new Comment();
                $comment->setContent($comments[$i]);
                $comment->setTrick($trick);
                $comment->setUser($this->getReference(UserFixtures::USER));
                $manager->persist($comment);
            }

            $manager->persist($trick);
        }

        foreach($trickNameRotations as $rotation) {
            $trick = new Trick();
            $trick->setName($rotation);
            $trick->setContent($trickContent);
            $slugger = new AsciiSlugger();
            $slug = $slugger->slug($trick->getName());
            $trick->setSlug(strtolower($slug));
            $trick->setUser($this->getReference(UserFixtures::USER));
            $trick->setGrouptrick($this->getReference("TrickGroup1"));

            for($i = 1; $i < 4; $i++) {
                $image = new Image();
                $image->setImagename("Snowboard-".rand(1, 3).".jpg");
                $image->setTricksId($trick);
                $image->setFile(NULL);
                $manager->persist($image);
            }

            for($i = 0; $i < 3; $i++) {
                $video = new Video();
                $video->setVideoname($videoLinks[$i]);
                $video->setVideoId(substr($videoLinks[$i], 32, 11));
                $video->setTrickId($trick);
                $manager->persist($video);
            }

            for($i = 0; $i < 3; $i++) {
                $comment = new Comment();
                $comment->setContent($comments[$i]);
                $comment->setTrick($trick);
                $comment->setUser($this->getReference(UserFixtures::USER));
                $manager->persist($comment);
            }

            $manager->persist($trick);
        }

        foreach($trickNameFlips as $flip) {
            $trick = new Trick();
            $trick->setName($flip);
            $trick->setContent($trickContent);
            $slugger = new AsciiSlugger();
            $slug = $slugger->slug($trick->getName());
            $trick->setSlug(strtolower($slug));
            $trick->setUser($this->getReference(UserFixtures::USER));
            $trick->setGrouptrick($this->getReference("TrickGroup2"));

            for($i = 1; $i < 4; $i++) {
                $image = new Image();
                $image->setImagename("Snowboard-".rand(1, 3).".jpg");
                $image->setTricksId($trick);
                $image->setFile(NULL);
                $manager->persist($image);
            }

            for($i = 0; $i < 3; $i++) {
                $video = new Video();
                $video->setVideoname($videoLinks[$i]);
                $video->setVideoId(substr($videoLinks[$i], 32, 11));
                $video->setTrickId($trick);
                $manager->persist($video);
            }

            for($i = 0; $i < 3; $i++) {
                $comment = new Comment();
                $comment->setContent($comments[$i]);
                $comment->setTrick($trick);
                $comment->setUser($this->getReference(UserFixtures::USER));
                $manager->persist($comment);
            }

            $manager->persist($trick);
        }

        foreach($trickNameSlides as $slide) {
            $trick = new Trick();
            $trick->setName($slide);
            $trick->setContent($trickContent);
            $slugger = new AsciiSlugger();
            $slug = $slugger->slug($trick->getName());
            $trick->setSlug(strtolower($slug));
            $trick->setUser($this->getReference(UserFixtures::USER));
            $trick->setGrouptrick($this->getReference("TrickGroup3"));

            for($i = 1; $i < 4; $i++) {
                $image = new Image();
                $image->setImagename("Snowboard-".rand(1, 3).".jpg");
                $image->setTricksId($trick);
                $image->setFile(NULL);
                $manager->persist($image);
            }

            for($i = 0; $i < 3; $i++) {
                $video = new Video();
                $video->setVideoname($videoLinks[$i]);
                $video->setVideoId(substr($videoLinks[$i], 32, 11));
                $video->setTrickId($trick);
                $manager->persist($video);
            }

            for($i = 0; $i < 3; $i++) {
                $comment = new Comment();
                $comment->setContent($comments[$i]);
                $comment->setTrick($trick);
                $comment->setUser($this->getReference(UserFixtures::USER));
                $manager->persist($comment);
            }

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
