<?php

namespace App\Service;

use App\Entity\Trick;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploadFile {

    private string $targetDirectory;
    private SluggerInterface $slugger;
    private EntityManagerInterface $entityManager;

    public function __construct($targetDirectory, SluggerInterface $slugger, EntityManagerInterface $entityManager) {

        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
        $this->entityManager = $entityManager;
    }

    public function upload(UploadedFile $file) {

            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
            try {
                $file->move($this->targetDirectory, $fileName);
                // TODO SETTER l'image name modifiée IMPORTANT !!!!!!!!!!!!!!!
            } catch (FileException $e) {
                return $e->getMessage();
            }
    }

    public function videoId() {
        // TODO utiliser parse_url / parse_str pour récupérer paramètre "v" de l'url d'une vidéo youtube
    }

    public function uploadFiles(Trick $trick) {

        foreach ($trick->getImages()->getValues() as $image) {

            $this->upload($image->getImagename());

            $trick->addImage($image);
        }

        foreach ($trick->getVideos() as $video) {

            // TODO utiliser méthode videoId pour getVideoname()

            $trick->addVideo($video);
        }
    }
}