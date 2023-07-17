<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints\All;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EbookRepository;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

    #[ORM\Column(type: 'json')]
    #[Vich\UploadableField(mapping: 'ebook_files', fileNameProperty: 'file')]
    private ?File $file ;

    // #[ORM\Column(type: 'string', length: 255, nullable: true)]
    // private ?string $filePath = null;

    // // Getter et Setter pour la propriété $filePath
    // public function getFilePath(): ?string
    // {
    //     return $this->filePath;
    // }

    // public function setFilePath(?string $filePath): self
    // {
    //     $this->filePath = $filePath;
    //     return $this;
    // }

    // Getter et Setter pour la propriété $file
    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file = null): self
    {
        $this->file = $file;
        if ($file) {
            // Mettez à jour la propriété "updatedAt" ou effectuez d'autres opérations liées au téléchargement du fichier
        }
        return $this;
    }

    // Autres getters et setters...

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
}
