<?php

namespace App\Entity;

use App\Repository\VillesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VillesRepository::class)]
class Villes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 5)]
    private ?string $codePostal = null;

    #[ORM\OneToMany(mappedBy: 'ville_idville', targetEntity: Lieux::class)]
    private Collection $lieuxes;

    public function __construct()
    {
        $this->lieuxes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): static
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * @return Collection<int, Lieux>
     */
    public function getLieuxes(): Collection
    {
        return $this->lieuxes;
    }

    public function addLieux(Lieux $lieux): static
    {
        if (!$this->lieuxes->contains($lieux)) {
            $this->lieuxes->add($lieux);
            $lieux->setVilleIdville($this);
        }

        return $this;
    }

    public function removeLieux(Lieux $lieux): static
    {
        if ($this->lieuxes->removeElement($lieux)) {
            // set the owning side to null (unless already changed)
            if ($lieux->getVilleIdville() === $this) {
                $lieux->setVilleIdville(null);
            }
        }

        return $this;
    }
}
