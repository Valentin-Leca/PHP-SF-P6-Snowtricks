<?php

namespace App\Service;

use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
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
            } catch (FileException $e) {
                return $e->getMessage();
            }
    }

    public function uploadFiles($images, $videos, Trick $trick) {

        foreach ($images as $image) {

            $this->upload($image);

            $trick->addImage($image);
            $this->entityManager->persist($trick);
        }

        foreach ($videos as $video) {

            $trick->addVideo($video);
            $this->entityManager->persist($trick);
        }
        $this->entityManager->flush();
    }
}