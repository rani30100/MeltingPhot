<?php
namespace App\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EbookRepository;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints\All;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

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

    
    #[ORM\Column(length: 255 , nullable: true)]
    private ? string $pdf =null;

    #[Vich\UploadableField(mapping: 'ebook_files', fileNameProperty: 'pdf')]
    private ?File $pdfFile = null;
    


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



 
    /**
     * Get the value of pdf
     */ 
    public function getPdf() : ?string
    {
        return $this->pdf;
    }

    /**
     * Set the value of pdf
     *
     * @return  self
     */ 
    public function setPdf($pdf)
    {
        $this->pdf = $pdf;

        return $this;
    }

    /**
     * Get the value of pdfFile
     */ 
    public function getPdfFile()
    {
        return $this->pdfFile;
    }

    /**
     * Set the value of pdfFile
     *
     * @return  self
     */ 
    public function setPdfFile($pdfFile)
    {
        $this->pdfFile = $pdfFile;

        return $this;
    }

    // Contraintes de Validation
    #[Assert\Callback]
    public function validatePdfFile(ExecutionContextInterface $context)
    {
        if ($this->pdfFile !== null && $this->pdfFile->getMimeType() !== 'application/pdf') {
            $context->buildViolation('Prend uniquement les livres numériques format pdf.')
                ->atPath('pdfFile')
                ->addViolation();
        }
    }

}
