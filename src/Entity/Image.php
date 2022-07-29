<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $imagename;

    #[ORM\ManyToOne(targetEntity: Trick::class, inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false)]
    private $tricks_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImagename(): ?string
    {
        return $this->imagename;
    }

    public function setImagename(string $imagename): self
    {
        $this->imagename = $imagename;

        return $this;
    }

    public function getTricksId(): ?Trick
    {
        return $this->tricks_id;
    }

    public function setTricksId(?Trick $tricks_id): self
    {
        $this->tricks_id = $tricks_id;

        return $this;
    }
}
