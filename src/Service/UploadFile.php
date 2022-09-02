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

    public function renameImage(UploadedFile $file, $image) {

            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
            try {
                $file->move($this->targetDirectory, $fileName);
                $image->setImagename($fileName);
            } catch (FileException $e) {
                return $e->getMessage();
            }
    }

    public function videoId(Video $video) {

        $originalUrl = $video->getVideoname();
        parse_str(parse_url($video->getVideoname(), PHP_URL_QUERY), $videoId);

        if (isset($videoId['v'])) {
            try {
                $video->setVideoname($videoId['v']);
                $video->setUrl($originalUrl);
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }

    public function uploadImage(Trick $trick) {

        foreach ($trick->getImages()->getValues() as $image) {

            $this->renameImage($image->getImagename(), $image);

            $trick->addImage($image);
        }
    }

    public function uploadVideo(Trick $trick) {
        foreach ($trick->getVideos() as $video) {

            $check = parse_url($video->getVideoname(), PHP_URL_HOST);
            parse_str(parse_url($video->getVideoname(), PHP_URL_QUERY), $videoId);

            if ($check === "www.youtube.com" && array_key_exists('v', $videoId)) {
                $this->videoId($video);
                $trick->addVideo($video);
            } else {
                return false;
            }
        }
    }
}