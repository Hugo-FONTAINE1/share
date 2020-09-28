<?php

namespace App\Entity;

use App\Repository\FichierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FichierRepository::class)
 */
class Fichier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $extension;

    /**
     * @ORM\Column(type="integer")
     */
    private $taille;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="fichiers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;

    /**
     * @ORM\ManyToMany(targetEntity=Theme::class, inversedBy="fichiers")
     */
    private $themes;

    /**
     * @ORM\OneToMany(targetEntity=Telechargement::class, mappedBy="Fichier")
     */
    private $telechargements;

    public function __construct()
    {
        $this->themes = new ArrayCollection();
        $this->telechargements = new ArrayCollection();
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

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(int $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * @return Collection|Theme[]
     */
    public function getThemes(): Collection
    {
        return $this->themes;
    }

    public function addTheme(Theme $theme): self
    {
        if (!$this->themes->contains($theme)) {
            $this->themes[] = $theme;
        }

        return $this;
    }

    public function removeTheme(Theme $theme): self
    {
        if ($this->themes->contains($theme)) {
            $this->themes->removeElement($theme);
        }

        return $this;
    }

    /**
     * @return Collection|Telechargement[]
     */
    public function getTelechargements(): Collection
    {
        return $this->telechargements;
    }

    public function addTelechargement(Telechargement $telechargement): self
    {
        if (!$this->telechargements->contains($telechargement)) {
            $this->telechargements[] = $telechargement;
            $telechargement->setFichier($this);
        }

        return $this;
    }

    public function removeTelechargement(Telechargement $telechargement): self
    {
        if ($this->telechargements->contains($telechargement)) {
            $this->telechargements->removeElement($telechargement);
            // set the owning side to null (unless already changed)
            if ($telechargement->getFichier() === $this) {
                $telechargement->setFichier(null);
            }
        }

        return $this;
    }
}
