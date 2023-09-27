<?php

namespace App\Entity;

use App\Entity\Page;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PostsRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PostsRepository::class)]
#[Vich\Uploadable]
#[ORM\HasLifecycleCallbacks]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\Column(type: "text")]
    private ?string $description = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $videoUrl = null;


    #[Vich\UploadableField(mapping: 'video_files', fileNameProperty: 'videoFile')]
    #[Assert\File(
        maxSize: "200M",
        mimeTypes: ["video/mp4", "video/avi", "video/mpeg"],
        mimeTypesMessage: "Seulement (MP4, AVI, MPEG)."
    )]
    private ?File $video = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $position = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;


    #[ORM\ManyToMany(targetEntity: Page::class, inversedBy: "post")]
    private Collection $pages;

    #[ORM\ManyToMany(targetEntity: Image::class, inversedBy: 'post')]
    private Collection $images;

    #[ORM\ManyToOne(inversedBy: 'userPost')]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: Video::class, inversedBy: 'post')]
    private Collection $videoFile;


    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateTimestamps(): void
    {
        $this->updatedAt = new \DateTime();
    }

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->pages = new ArrayCollection();
        $this->images = new ArrayCollection();
        // $this->videoPost = new ArrayCollection();
        $this->videoFile = new ArrayCollection();
    }
    public function __toString()
    {  
        
        return (string) $this->getTitle();
    }

    public function getPages(): Collection
    {
        return $this->pages;
    }

    public function addPage(Page $page): self
    {
        if (!$this->pages->contains($page)) {
            $this->pages[] = $page;
        }

        return $this;
    }

    public function removePage(Page $page): self
    {
        $this->pages->removeElement($page);

        return $this;
    }


    public function setVideo(?File $video = null): void
    {
        $this->video = $video;

        if (null !== $video) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }


    public function getVideoUrl(): ?string
    {
        return $this->videoUrl;
    }

    public function setVideoUrl(?string $videoUrl): self
    {
        $this->videoUrl = $videoUrl;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): self
    {
        $this->position = $position;

        return $this;
    }


    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }



    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }


    public function getVideo(): ?File
    {
        return $this->video;
    }



    /**
     * Get the value of imageSize
     */
    public function getImageSize()
    {
        return $this->imageSize;
    }

    /**
     * Set the value of imageSize
     *
     * @return  self
     */
    public function setImageSize($imageSize)
    {
        $this->imageSize = $imageSize;

        return $this;
    }

    public function getType()
    {
        return "post";
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        $this->images->removeElement($image);

        return $this;
    }


    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Video>
     */
    public function getVideoFile(): Collection
    {
        return $this->videoFile;
    }

    public function addVideoFile(Video $videoFile): static
    {
        if (!$this->videoFile->contains($videoFile)) {
            $this->videoFile->add($videoFile);
        }

        return $this;
    }

    public function removeVideoFile(Video $videoFile): static
    {
        $this->videoFile->removeElement($videoFile);

        return $this;
    }


}
