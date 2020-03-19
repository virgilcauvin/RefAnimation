<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeFestivalRepository")
 */
class TypeFestival
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\EditionFestival", mappedBy="TypeFestivals")
     */
    private $editionFestivals;

    public function __construct()
    {
        $this->editionFestivals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|EditionFestival[]
     */
    public function getEditionFestivals(): Collection
    {
        return $this->editionFestivals;
    }

    public function addEditionFestival(EditionFestival $editionFestival): self
    {
        if (!$this->editionFestivals->contains($editionFestival)) {
            $this->editionFestivals[] = $editionFestival;
            $editionFestival->addTypeFestival($this);
        }

        return $this;
    }

    public function removeEditionFestival(EditionFestival $editionFestival): self
    {
        if ($this->editionFestivals->contains($editionFestival)) {
            $this->editionFestivals->removeElement($editionFestival);
            $editionFestival->removeTypeFestival($this);
        }

        return $this;
    }
}
