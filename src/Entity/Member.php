<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
class Member
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: PlantCatalogue::class)]
    private Collection $memberCatalogue;

    #[ORM\OneToMany(mappedBy: 'createur', targetEntity: Galerie::class)]
    private Collection $createur;

    #[ORM\OneToOne(mappedBy: 'usermember', cascade: ['persist', 'remove'])]
    private ?User $memberuser = null;

   
    public function __construct()
    {
        $this->memberCatalogue = new ArrayCollection();
        $this->createur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, PlantCatalogue>
     */
    public function getMemberCatalogue(): Collection
    {
        return $this->memberCatalogue;
    }

    public function addMemberCatalogue(PlantCatalogue $memberCatalogue): static
    {
        if (!$this->memberCatalogue->contains($memberCatalogue)) {
            $this->memberCatalogue->add($memberCatalogue);
            $memberCatalogue->setMember($this);
        }

        return $this;
    }

    public function removeMemberCatalogue(PlantCatalogue $memberCatalogue): static
    {
        if ($this->memberCatalogue->removeElement($memberCatalogue)) {
            // set the owning side to null (unless already changed)
            if ($memberCatalogue->getMember() === $this) {
                $memberCatalogue->setMember(null);
            }
        }

        return $this;
    }



    public function __toString() {
        return $this->getNom() . $this->getDescription() . $this->getId();
    }

    /**
     * @return Collection<int, Galerie>
     */
    public function getCreateur(): Collection
    {
        return $this->createur;
    }

    public function addCreateur(Galerie $createur): static
    {
        if (!$this->createur->contains($createur)) {
            $this->createur->add($createur);
            $createur->setCreateur($this);
        }

        return $this;
    }

    public function removeCreateur(Galerie $createur): static
    {
        if ($this->createur->removeElement($createur)) {
            // set the owning side to null (unless already changed)
            if ($createur->getCreateur() === $this) {
                $createur->setCreateur(null);
            }
        }

        return $this;
    }

    public function getMemberuser(): ?User
    {
        return $this->memberuser;
    }

    public function setMemberuser(?User $memberuser): static
    {
        // unset the owning side of the relation if necessary
        if ($memberuser === null && $this->memberuser !== null) {
            $this->memberuser->setUsermember(null);
        }

        // set the owning side of the relation if necessary
        if ($memberuser !== null && $memberuser->getUsermember() !== $this) {
            $memberuser->setUsermember($this);
        }

        $this->memberuser = $memberuser;

        return $this;
    }


    
}
