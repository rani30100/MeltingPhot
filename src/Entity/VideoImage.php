<?php

namespace App\Entity;

use App\Repository\VideoImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VideoImageRepository::class)]
class VideoImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $imagePath = null;

    #[ORM\ManyToMany(targetEntity: Video::class, inversedBy: 'images')]
    private $videos;


    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(string $imagePath): self
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    /**
     * Get the value of videos
     */ 
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * Set the value of videos
     *
     * @return  self
     */ 
    public function setVideos($videos)
    {
        $this->videos = $videos;

        return $this;
    }
}
