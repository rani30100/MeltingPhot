<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EbookRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: EbookRepository::class)]
class Ebook
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'ebook', targetEntity: EbookImage::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    private $images;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;


    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->author;
        return $this->title;
        return $this->description;
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return Collection|EbookImage[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(EbookImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setEbook($this);
        }

        return $this;
    }

    public function removeImage(EbookImage $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getEbook() === $this) {
                $image->setEbook(null);
            }
        }

        return $this;
    }



    /**
     * Get the value of author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set the value of author
     *
     * @return  self
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Set the value of images
     *
     * @return  self
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @return Collection<int, EbookImage>
     */
    public function getEbookImages(): Collection
    {
        return $this->images;
    }
}
