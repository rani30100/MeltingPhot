<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Odonymes = null;

    #[ORM\Column(length: 255)]
    private ?string $Je_filme_mon_futur_metier = null;

    #[ORM\Column(length: 255)]
    private ?string $Les_critiques_petillantes = null;

    #[ORM\Column(length: 255)]
    private ?string $Parole_public = null;

    #[ORM\Column(length: 255)]
    private ?string $Les_vitrines_des_cevennes = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOdonymes(): ?string
    {
        return $this->Odonymes;
    }

    public function setOdonymes(string $Odonymes): self
    {
        $this->Odonymes = $Odonymes;

        return $this;
    }

    public function getJeFilmeMonFuturMetier(): ?string
    {
        return $this->Je_filme_mon_futur_metier;
    }

    public function setJeFilmeMonFuturMetier(string $Je_filme_mon_futur_metier): self
    {
        $this->Je_filme_mon_futur_metier = $Je_filme_mon_futur_metier;

        return $this;
    }

    public function getLesCritiquesPetillantes(): ?string
    {
        return $this->Les_critiques_petillantes;
    }

    public function setLesCritiquesPetillantes(string $Les_critiques_petillantes): self
    {
        $this->Les_critiques_petillantes = $Les_critiques_petillantes;

        return $this;
    }

    public function getParolePublic(): ?string
    {
        return $this->Parole_public;
    }

    public function setParolePublic(string $Parole_public): self
    {
        $this->Parole_public = $Parole_public;

        return $this;
    }

    public function getLesVitrinesDesCevennes(): ?string
    {
        return $this->Les_vitrines_des_cevennes;
    }

    public function setLesVitrinesDesCevennes(string $Les_vitrines_des_cevennes): self
    {
        $this->Les_vitrines_des_cevennes = $Les_vitrines_des_cevennes;

        return $this;
    }
}
