<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DepartementRepository::class)
 */
class Departement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Cgo::class, mappedBy="departements")
     */
    private $cgos;

    /**
     * @ORM\OneToMany(targetEntity=Ville::class, mappedBy="departement")
     */
    private $villes;

    public function __construct()
    {
        $this->cgos = new ArrayCollection();
        $this->villes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Cgo>
     */
    public function getCgos(): Collection
    {
        return $this->cgos;
    }

    public function addCgo(Cgo $cgo): self
    {
        if (!$this->cgos->contains($cgo)) {
            $this->cgos[] = $cgo;
        }

        return $this;
    }

    public function removeCgo(Cgo $cgo): self
    {
        $this->cgos->removeElement($cgo);

        return $this;
    }

    /**
     * @return Collection<int, Ville>
     */
    public function getVilles(): Collection
    {
        return $this->villes;
    }

    public function addVille(Ville $ville): self
    {
        if (!$this->villes->contains($ville)) {
            $this->villes[] = $ville;
            $ville->setDepartement($this);
        }

        return $this;
    }

    public function removeVille(Ville $ville): self
    {
        if ($this->villes->removeElement($ville)) {
            // set the owning side to null (unless already changed)
            if ($ville->getDepartement() === $this) {
                $ville->setDepartement(null);
            }
        }

        return $this;
    }
}
