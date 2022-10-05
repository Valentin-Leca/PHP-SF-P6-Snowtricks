<?php

namespace App\Service;

use App\Entity\Trick;
use App\Entity\Video;
use Exception;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploadFile {

    private string $targetDirectory;
    private SluggerInterface $slugger;

    public function __construct($targetDirectory, SluggerInterface $slugger) {

        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }

    public function renameImage(UploadedFile $file): string {

            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
            try {
                $file->move($this->getTargetDirectory(), $fileName);
            } catch (FileException $e) {
                return $e->getMessage();
            }
            return $fileName;
    }

    public function uploadImage(Trick $trick): void {

        foreach ($trick->getImages() as $image) {

            if ($image->getFile() !== null) {
                $image->setImagename($this->renameImage($image->getFile()));
            } elseif ($image->getImagename() === null && $image->getFile() === null) {
                $trick->removeImage($image);
            }
        }
    }

    public function videoId(Video $video): string {

        $originalUrl = $video->getVideoname();
        parse_str(parse_url($video->getVideoname(), PHP_URL_QUERY), $videoId);

        if (isset($videoId['v'])) {
            try {
                $video->setVideoname($originalUrl);
                $video->setVideoId($videoId['v']);
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
        return $video->getVideoId();
    }

    public function uploadVideo(Trick $trick): void {

        foreach ($trick->getVideos() as $video) {

            $check = parse_url($video->getVideoname(), PHP_URL_HOST);
            parse_str(parse_url($video->getVideoname(), PHP_URL_QUERY), $videoId);

            if ($check === "www.youtube.com" && array_key_exists('v', $videoId)) {
                $this->videoId($video);
                $trick->addVideo($video);
            } elseif ($video->getVideoname() === null || $video->getVideoId() === null) {
                $trick->removeVideo($video);
            }
        }
    }

    public function getTargetDirectory(): string {
        return $this->targetDirectory;
    }
}
