<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ImageRepository;
use Vich\UploaderBundle\Entity\File;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
#[Vich\Uploadable]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    // #[Vich\UploadableField(mapping: 'post_images', fileNameProperty: 'path')]
    private ?string $path = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Posts::class,inversedBy:"imagesCollection")]
    #[ORM\JoinColumn(name: 'post_id', referencedColumnName: 'id')]
    private ?Posts $post = null;

    #[ORM\ManyToOne(targetEntity: Page::class)] 
    #[ORM\JoinColumn(name: 'page_id', referencedColumnName: 'id')]
    private ?Page $page = null;

    #[ORM\Column(type: 'datetime')]
    private ?DateTimeInterface $created_at = null;

    #[ORM\ManyToMany(targetEntity: Page::class, inversedBy: 'images')]
    private Collection $pages;
    

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->pages = new ArrayCollection();
        // $this->imageFile = null; // Initialisation de l'imageFile à null
    }
    
    public function __toString()
{
    return $this->getTitle() ?? ''; // Utilisez le titre s'il est défini, sinon une chaîne vide.
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

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

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

    public function getPost(): ?Posts
    {
        return $this->post;
    }

    public function setPost(?Posts $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getType() {
        return "image";
    }

    /**
     * @return Collection<int, Page>
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    public function addPage(Page $page): static
    {
        if (!$this->pages->contains($page)) {
            $this->pages->add($page);
            $page->addImage($this);
        }

        return $this;
    }

    public function removePage(Page $page): static
    {
        if ($this->pages->removeElement($page)) {
            $page->removeImage($this);
        }

        return $this;
    }

    // /**
    //  * Get the value of images_page
    //  */ 
    // public function getImages_page()
    // {
    //     return $this->images_page;
    // }

    // /**
    //  * Set the value of images_page
    //  *
    //  * @return  self
    //  */ 
    // public function setImages_page($images_page)
    // {
    //     $this->images_page = $images_page;

    //     return $this;
    // }


    // /**
    //  * Get the value of imageFile
    //  */
    // public function getImageFile(): ?File
    // {
    //     return $this->imageFile;
    // }

   
    // public function setImageFile(?File $imageFile = null): void
    // {
    //     $this->imageFile = $imageFile;

    //     if (null !== $imageFile) {
    //         // Il faut biensur que la propriété updatedAt soit crée sur l'Entity.
    //         $this->updatedAt = new \DateTimeImmutable();
    //     }
    // }

    /**
     * Get the value of updatedAt
     */ 
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */ 
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Page>
     */
    public function getImagePage(): Collection
    {
        return $this->imagePage;
    }

    public function addImagePage(Page $imagePage): static
    {
        if (!$this->imagePage->contains($imagePage)) {
            $this->imagePage->add($imagePage);
        }

        return $this;
    }

    public function removeImagePage(Page $imagePage): static
    {
        $this->imagePage->removeElement($imagePage);

        return $this;
    }
}