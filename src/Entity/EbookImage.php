<?php

namespace App\Entity;

use App\Entity\Ebook;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EbookImageRepository;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
#[ORM\Entity(repositoryClass: EbookImageRepository::class)]
#[Vich\Uploadable]
class EbookImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(nullable:true)]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: 'ebook_images', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Ebook $ebook = null;

    
    public function __toString(): string
    {
        return $this->imageName ?? ''; // Si imageName est null, retourne une chaîne vide        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setImageFile(?array $imageFiles = null): void
    {
        if (null === $imageFiles) {
            return;
        }
    
        foreach ($imageFiles as $imageFile) {
            $this->imageFile[] = $imageFile;
    
            if (null !== $imageFile) {
                $this->updatedAt = new \DateTimeImmutable();
            }
        }
    }
    
    public function getImageFile(): ?array
    {
        return $this->imageFile;
    }
    
    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function setImageSize(?int $imageSize): self
    {
        $this->imageSize = $imageSize;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getEbook(): ?Ebook
    {
        return $this->ebook;
    }

    public function setEbook(?Ebook $ebook): self
    {
        $this->ebook = $ebook;

        return $this;
    }


}