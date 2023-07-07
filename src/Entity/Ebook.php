<?php

namespace App\Entity;

use App\Repository\EbookRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: EbookRepository::class)]
#[Vich\Uploadable]
class Ebook
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    
    #[ORM\Column(length: 255)]
    private ?string $file = null;
    
    #[Vich\UploadableField(mapping:"ebook_files", fileNameProperty:"file")]
    private $ebookFile;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

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

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

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

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }


    public function setEbook(string $ebookFile): self
    {
        $this->ebookFile = $ebookFile;
    
        if (null !== $ebookFile) {
            // Il est nécessaire qu'au moins un champ change si vous utilisez Doctrine,
            // sinon les écouteurs d'événements ne seront pas appelés et le fichier sera perdu
            $this->updatedAt = new \DateTimeImmutable();
        }
    
        return $this;
    }
    

}
