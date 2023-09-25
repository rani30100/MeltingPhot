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
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[ORM\Entity(repositoryClass: PostsRepository::class)]
#[Vich\Uploadable]
#[ORM\HasLifecycleCallbacks]
class Posts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id',referencedColumnName: 'id')]
    private ?User $user;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $path = null;

    #[Vich\UploadableField(mapping: 'post_images', fileNameProperty: 'path', size: 'imageSize')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\Column(type: "text")]
    private ?string $description = null;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $img_Id = null;

    #[ORM\OneToOne(targetEntity: Image::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: "img_id", referencedColumnName: "id")]
    private ?Image $image = null;


    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: "post", cascade: ["persist", "remove"], orphanRemoval: true)]
    #[Assert\Valid()]
    private Collection $imagesCollection;


    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $videoUrl = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $videoFile = null;

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


    #[ORM\ManyToMany(targetEntity: Page::class, inversedBy: "posts")]
    private Collection $pages;


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
        $this->imagesCollection = new ArrayCollection();
        $this->pages = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->getTitle();
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


    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;
        return $this;
    }


    // public function setVideo(?File $video = null): self
    // {
    //     $this->video = $video;

    //     return $this;
    // }

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getImagesCollection(): Collection
    {
        return $this->imagesCollection;
    }

    public function addImage(Image $image): self
    {
        if (!$this->imagesCollection->contains($image)) {
            $this->imagesCollection[] = $image;
            $image->setPost($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->imagesCollection->removeElement($image)) {
            if ($image->getPost() === $this) {
                $image->setPost(null);
            }
        }

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

    public function setVideoFile(?string $videoFile): self
    {
        $this->videoFile = $videoFile;

        return $this;
    }

    /**
     * Get the value of videoFile
     */
    public function getVideoFile()
    {
        return $this->videoFile;
    }




    public function getImgId(): ?int
    {
        return $this->img_Id;
    }

    public function setImgId(?int $img_Id): static
    {
        $this->img_Id = $img_Id;

        return $this;
    }

    public function addImagesCollection(Image $imagesCollection): static
    {
        if (!$this->imagesCollection->contains($imagesCollection)) {
            $this->imagesCollection->add($imagesCollection);
            $imagesCollection->setPost($this);
        }

        return $this;
    }

    public function removeImagesCollection(Image $imagesCollection): static
    {
        if ($this->imagesCollection->removeElement($imagesCollection)) {
            // set the owning side to null (unless already changed)
            if ($imagesCollection->getPost() === $this) {
                $imagesCollection->setPost(null);
            }
        }

        return $this;
    }




    /**
     * Get the value of imageFile
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // Il faut biensur que la propriété updatedAt soit crée sur l'Entity.
            $this->updatedAt = new \DateTimeImmutable();
        }
    }
    /**
     * Get the value of path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the value of path
     *
     * @return  self
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
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
}
