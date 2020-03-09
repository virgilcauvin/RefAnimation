<?php

namespace App\Entity;

use App\Entity\Langue;
use App\Entity\Festival;
use App\Entity\Categorie;
use Cocur\Slugify\Slugify;
use App\Entity\PublicCible;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FilmRepository")
 * @Vich\Uploadable
 */
class Film
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $filename;

    /**
     * @var File|null
     * @Assert\Image(mimeTypes="image/jpeg")
     * @vich\UploadableField(mapping="film_image", fileNameProperty="filename")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duree;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $realisateur;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $annee_de_production;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duree_de_production;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $lien_video;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $traduit_fr;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $soustitres_fr;    

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Categorie", inversedBy="films")
     * @ORM\JoinTable(name="film_categorie")
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Festival", inversedBy="films")
     * @ORM\JoinTable(name="film_festival")
     */
    private $festivals;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PublicCible", inversedBy="films")
     */
    private $public_cibles;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Langue", inversedBy="films")
     */
    private $langues;

    public function __construct()
    {
        $this->created_at = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->categories = new ArrayCollection();
        $this->festivals = new ArrayCollection();
        $this->public_cibles = new ArrayCollection();
        $this->langues = new ArrayCollection();
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

    public function getSlug()
    {
        return (new Slugify())->slugify($this->nom);
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDate(): ?int
    {
        return $this->date;
    }

    public function setDate(?int $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getRealisateur(): ?string
    {
        return $this->realisateur;
    }

    public function setRealisateur(?string $realisateur): self
    {
        $this->realisateur = $realisateur;

        return $this;
    }

    public function getAnneeDeProduction(): ?int
    {
        return $this->annee_de_production;
    }

    public function setAnneeDeProduction(?int $annee_de_production): self
    {
        $this->annee_de_production = $annee_de_production;

        return $this;
    }

    public function getDureeDeProduction(): ?int
    {
        return $this->duree_de_production;
    }

    public function setDureeDeProduction(?int $duree_de_production): self
    {
        $this->duree_de_production = $duree_de_production;

        return $this;
    }

    public function getLienVideo(): ?string
    {
        return $this->lien_video;
    }

    public function setLienVideo(?string $lien_video): self
    {
        $this->lien_video = $lien_video;

        return $this;
    }

    public function getTraduitFr(): ?bool
    {
        return $this->traduit_fr;
    }

    public function setTraduitFr(?bool $traduit_fr): self
    {
        $this->traduit_fr = $traduit_fr;

        return $this;
    }

    public function getSoustitresFr(): ?bool
    {
        return $this->soustitres_fr;
    }

    public function setSoustitresFr(?bool $soustitres_fr): self
    {
        $this->soustitres_fr = $soustitres_fr;

        return $this;
    }

    /**
     * @return Collection|Categorie[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }

    /**
     * @return Collection|Festival[]
     */
    public function getFestivals(): Collection
    {
        return $this->festivals;
    }

    public function addFestival(Festival $festival): self
    {
        if (!$this->festivals->contains($festival)) {
            $this->festivals[] = $festival;
        }

        return $this;
    }

    public function removeFestival(Festival $festival): self
    {
        if ($this->festivals->contains($festival)) {
            $this->festivals->removeElement($festival);
        }

        return $this;
    }

    /**
     * Get the value of imageFile
     *
     * @return  File|null
     */ 
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Set the value of imageFile
     *
     * @param  File|null  $imageFile
     *
     * @return  self
     */ 
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;
        if ($this->imageFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        }
        return $this;
    }

    /**
     * Get the value of filename
     *
     * @return  string|null
     */ 
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set the value of filename
     *
     * @param  string|null  $filename
     *
     * @return  self
     */ 
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection|PublicCible[]
     */
    public function getPublicCibles(): Collection
    {
        return $this->public_cibles;
    }

    public function addPublicCible(PublicCible $publicCible): self
    {
        if (!$this->public_cibles->contains($publicCible)) {
            $this->public_cibles[] = $publicCible;
        }

        return $this;
    }

    public function removePublicCible(PublicCible $publicCible): self
    {
        if ($this->public_cibles->contains($publicCible)) {
            $this->public_cibles->removeElement($publicCible);
        }

        return $this;
    }

    /**
     * @return Collection|Langue[]
     */
    public function getLangues(): Collection
    {
        return $this->langues;
    }

    public function addLangue(Langue $langue): self
    {
        if (!$this->langues->contains($langue)) {
            $this->langues[] = $langue;
        }

        return $this;
    }

    public function removeLangue(Langue $langue): self
    {
        if ($this->langues->contains($langue)) {
            $this->langues->removeElement($langue);
        }

        return $this;
    }
}
