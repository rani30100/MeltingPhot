<?php

namespace App\Entity;

use DateTime;
use DateTimeImmutable;
use App\Entity\VideoImage;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\VideoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
class Video
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'created_at')]
    private ?User $user = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\ManyToOne(inversedBy: 'videos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'video', targetEntity: VideoImage::class, cascade: ['persist', 'remove'])]
    private $images;
    

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $videoImage = null;
    

    public function __construct()
    {
        $this->created_at = new DateTimeImmutable('now');
        $this->images = new ArrayCollection();
    }

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }


    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(VideoImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->addVideo($this);
        }

        return $this;
    }

    public function removeImage(VideoImage $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            $image->removeVideo($this);
        }

        return $this;
    }

    public function getVideoImage(): ?string
    {
        return $this->videoImage;
    }

    public function setVideoImage(?string $videoImage): self
    {
        $this->videoImage = $videoImage;

        return $this;
    }
}
