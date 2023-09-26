<?php

namespace App\Entity;

use DateTimeInterface;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


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

    #[ORM\Column(length: 255,nullable: true)]
    private ?string $path;


    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;


    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?User $user = null;


    #[ORM\ManyToOne(targetEntity: Page::class, cascade:["remove"])]
    #[ORM\JoinColumn(name: 'page_id', referencedColumnName: 'id')]
    private ?Page $page = null;


    #[ORM\Column(type: 'datetime')]
    private ?DateTimeInterface $created_at = null;

    #[ORM\ManyToMany(targetEntity: Page::class, inversedBy: 'images')]
    private Collection $pages;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToMany(targetEntity: Post::class, mappedBy: 'images')]
    private Collection $post;


    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->pages = new ArrayCollection();
        $this->post = new ArrayCollection();
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

    public function setPath(string $path): void
    {
        $this->path = $path;

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

    public function getType()
    {
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



    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

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
        return $this->pages;
    }

    public function addImagePage(Page $imagePage): static
    {
        if (!$this->pages->contains($imagePage)) {
            $this->pages->add($imagePage);
        }

        return $this;
    }

    public function removeImagePage(Page $imagePage): static
    {
        $this->pages->removeElement($imagePage);

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPost(): Collection
    {
        return $this->post;
    }

    public function addPost(Post $post): static
    {
        if (!$this->post->contains($post)) {
            $this->post->add($post);
            $post->addImage($this);
        }

        return $this;
    }

    public function removePost(Post $post): static
    {
        if ($this->post->removeElement($post)) {
            $post->removeImage($this);
        }

        return $this;
    }



}
