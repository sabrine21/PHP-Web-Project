<?php

namespace App\Entity;

use App\Repository\GalerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GalerieRepository::class)]
class Galerie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    #[ORM\Column]
    private ?bool $Publiee = null;

    #[ORM\ManyToOne(inversedBy: 'createur')]
    private ?Member $createur = null;

    #[ORM\ManyToMany(targetEntity: Plant::class, inversedBy: 'galerie_objet')]
    private Collection $galerie_objet;

    #[ORM\ManyToOne(inversedBy: 'galeries')]
    private ?PlantCatalogue $plantcatalogue = null;

    public function __construct()
    {
        $this->galerie_objet = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function isPubliee(): ?bool
    {
        return $this->Publiee;
    }

    public function setPubliee(bool $Publiee): static
    {
        $this->Publiee = $Publiee;

        return $this;
    }

    public function getCreateur(): ?Member
    {
        return $this->createur;
    }

    public function setCreateur(?Member $createur): static
    {
        $this->createur = $createur;

        return $this;
    }

    /**
     * @return Collection<int, Plant>
     */
    public function getGalerieObjet(): Collection
    {
        return $this->galerie_objet;
    }

    public function addGalerieObjet(Plant $galerieObjet): static
    {
        if (!$this->galerie_objet->contains($galerieObjet)) {
            $this->galerie_objet->add($galerieObjet);
        }

        return $this;
    }

    public function removeGalerieObjet(Plant $galerieObjet): static
    {
        $this->galerie_objet->removeElement($galerieObjet);

        return $this;
    }

    public function getPlantcatalogue(): ?PlantCatalogue
    {
        return $this->plantcatalogue;
    }

    public function setPlantcatalogue(?PlantCatalogue $plantcatalogue): static
    {
        $this->plantcatalogue = $plantcatalogue;

        return $this;
    }
}
