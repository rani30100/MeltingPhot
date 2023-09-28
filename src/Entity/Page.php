<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PageRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[ORM\Entity(repositoryClass: PageRepository::class)]
#[ORM\Index(name: "slug", columns: ["slug"])]
#[UniqueEntity('slug')]
class Page
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable :true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\ManyToMany(targetEntity: Post::class, cascade:["remove"])]     
    private Collection $post;

    #[ORM\ManyToMany(targetEntity: Image::class, mappedBy: 'pages', cascade: ["remove"])]
    private Collection $images;

    #[ORM\ManyToOne(inversedBy: 'page')]
    private ?User $user = null;

    
    
    // #[ORM\ManyToMany(targetEntity: Image::class, inversedBy: 'pages', cascade:['remove'])]
    // private Collection $images;

    public function __construct()
    {
        $this->post = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function __toString()
    {

        return (string) $this->getTitle();
    }
    public function getPost(): Collection
    {
        return $this->post;
    }

    public function addPost(Post $post): self
    {
        if (!$this->post->contains($post)) {
            $this->post[] = $post;
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        $this->post->removeElement($post);

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function pageSlug(SluggerInterface $slugger)
    {
        if (!$this->slug || '-' === $this->slug) {
            $this->slug = (string) $slugger->slug((string) $this)->lower();
        }
    }
    public function getType() {
        return "image";
    }

    // /**
    //  * @return Collection<int, Image>
    //  */
    // public function getImages(): Collection
    // {
    //     return $this->images;
    // }

    // public function addImage(Image $image): static
    // {
    //     if (!$this->images->contains($image)) {
    //         $this->images->add($image);
    //     }

    //     return $this;
    // }

    // public function removeImage(Image $image): static
    // {
    //     $this->images->removeElement($image);

    //     return $this;
    // }

    

    // /**
    //  * Set the value of images
    //  *
    //  * @return  self
    //  */ 
    // public function setImages($images)
    // {
    //     $this->images = $images;

    //     return $this;
    // }

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
            $image->addImagePage($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            $image->removeImagePage($this);
        }

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

}
