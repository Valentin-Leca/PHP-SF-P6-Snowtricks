<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
class Video
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotNull]
    private ?string $videoname;

    #[ORM\ManyToOne(targetEntity: trick::class, inversedBy: 'videos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?trick $trick_id;

    #[ORM\Column(type: 'string', length: 255)]
    private $videoId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVideoname(): ?string
    {
        return $this->videoname;
    }

    public function setVideoname(string $videoname): self
    {
        $this->videoname = $videoname;

        return $this;
    }

    public function getTrickId(): ?trick
    {
        return $this->trick_id;
    }

    public function setTrickId(?trick $trick_id): self
    {
        $this->trick_id = $trick_id;

        return $this;
    }

    public function getVideoId(): ?string
    {
        return $this->videoId;
    }

    public function setVideoId(string $videoId): self
    {
        $this->videoId = $videoId;

        return $this;
    }
}
