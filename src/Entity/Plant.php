<?php

namespace App\Entity;

use App\Repository\PlantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlantRepository::class)]
class Plant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $PlantName = null;

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    #[ORM\Column(length: 255)]
    private ?string $Prix = null;

    #[ORM\Column(length: 255)]
    private ?string $Stock = null;

    #[ORM\ManyToOne(inversedBy: 'listeObjets')]
    private ?PlantCatalogue $categorie = null;

    #[ORM\ManyToMany(targetEntity: Galerie::class, mappedBy: 'galerie_objet')]
    private Collection $galerie_objet;

    #[ORM\Column(length: 255)]
    private ?string $img = null;

    public function __construct()
    {
        $this->galerie_objet = new ArrayCollection();
    }

   

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlantName(): ?string
    {
        return $this->PlantName;
    }

    public function setPlantName(string $PlantName): static
    {
        $this->PlantName = $PlantName;

        return $this;
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

    public function getPrix(): ?string
    {
        return $this->Prix;
    }

    public function setPrix(string $Prix): static
    {
        $this->Prix = $Prix;

        return $this;
    }

    public function getStock(): ?string
    {
        return $this->Stock;
    }

    public function setStock(string $Stock): static
    {
        $this->Stock = $Stock;

        return $this;
    }

    public function getCategorie(): ?PlantCatalogue
    {
        return $this->categorie;
    }

    public function setCategorie(?PlantCatalogue $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }


    public function __toString() {
        return $this->getPlantName() . $this->getDescription() . $this->getPrix(). $this->getStock(). $this->getId();
    }

    /**
     * @return Collection<int, Galerie>
     */
    public function getGalerieObjet(): Collection
    {
        return $this->galerie_objet;
    }

    public function addGalerieObjet(Galerie $galerieObjet): static
    {
        if (!$this->galerie_objet->contains($galerieObjet)) {
            $this->galerie_objet->add($galerieObjet);
            $galerieObjet->addGalerieObjet($this);
        }

        return $this;
    }

    public function removeGalerieObjet(Galerie $galerieObjet): static
    {
        if ($this->galerie_objet->removeElement($galerieObjet)) {
            $galerieObjet->removeGalerieObjet($this);
        }

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): static
    {
        $this->img = $img;

        return $this;
    }


    

    

}
