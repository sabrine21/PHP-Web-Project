<?php

namespace App\Entity;

use App\Repository\PlantCatalogueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlantCatalogueRepository::class)]
class PlantCatalogue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $CategorieName = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Plant::class)]
    private Collection $listeObjets;

    #[ORM\ManyToOne(inversedBy: 'memberCatalogue')]
    private ?Member $member = null;

    #[ORM\OneToMany(mappedBy: 'plantcatalogue', targetEntity: Galerie::class)]
    private Collection $galeries;

    public function __construct()
    {
        $this->listeObjets = new ArrayCollection();
        $this->galeries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategorieName(): ?string
    {
        return $this->CategorieName;
    }

    public function setCategorieName(string $CategorieName): static
    {
        $this->CategorieName = $CategorieName;

        return $this;
    }

    /**
     * @return Collection<int, Plant>
     */
    public function getListeObjets(): Collection
    {
        return $this->listeObjets;
    }

    public function addListeObjet(Plant $listeObjet): static
    {
        if (!$this->listeObjets->contains($listeObjet)) {
            $this->listeObjets->add($listeObjet);
            $listeObjet->setCategorie($this);
        }

        return $this;
    }
    
   
    public function __toString() {
        return $this->getCategorieName() . $this->getId();
    }
   

    

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): static
    {
        $this->member = $member;

        return $this;
    }

    /**
     * @return Collection<int, Galerie>
     */
    public function getGaleries(): Collection
    {
        return $this->galeries;
    }

    public function addGalery(Galerie $galery): static
    {
        if (!$this->galeries->contains($galery)) {
            $this->galeries->add($galery);
            $galery->setPlantcatalogue($this);
        }

        return $this;
    }

    public function removeGalery(Galerie $galery): static
    {
        if ($this->galeries->removeElement($galery)) {
            // set the owning side to null (unless already changed)
            if ($galery->getPlantcatalogue() === $this) {
                $galery->setPlantcatalogue(null);
            }
        }

        return $this;
    }




}
