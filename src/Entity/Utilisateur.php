<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
class Utilisateur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $prenom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datenaissance;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateinscription;

    /**
     * @ORM\OneToMany(targetEntity=Fichier::class, mappedBy="utilisateur")
     */
    private $fichiers;

    /**
     * @ORM\OneToMany(targetEntity=Telechargement::class, mappedBy="Utilisateur")
     */
    private $telechargements;

    public function __construct()
    {
        $this->fichiers = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDatenaissance(): ?\DateTimeInterface
    {
        return $this->datenaissance;
    }

    public function setDatenaissance(\DateTimeInterface $datenaissance): self
    {
        $this->datenaissance = $datenaissance;

        return $this;
    }

    public function getDateinscription(): ?\DateTimeInterface
    {
        return $this->dateinscription;
    }

    public function setDateinscription(\DateTimeInterface $dateinscription): self
    {
        $this->dateinscription = $dateinscription;

        return $this;
    }

    /**
     * @return Collection|Fichier[]
     */
    public function getFichiers(): Collection
    {
        return $this->fichiers;
    }

    public function addFichier(Fichier $fichier): self
    {
        if (!$this->fichiers->contains($fichier)) {
            $this->fichiers[] = $fichier;
            $fichier->setUtilisateur($this);
        }

        return $this;
    }

    public function removeFichier(Fichier $fichier): self
    {
        if ($this->fichiers->contains($fichier)) {
            $this->fichiers->removeElement($fichier);
            // set the owning side to null (unless already changed)
            if ($fichier->getUtilisateur() === $this) {
                $fichier->setUtilisateur(null);
            }
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
            $telechargement->setUtilisateur($this);
        }

        return $this;
    }

    public function removeTelechargement(Telechargement $telechargement): self
    {
        if ($this->telechargements->contains($telechargement)) {
            $this->telechargements->removeElement($telechargement);
            // set the owning side to null (unless already changed)
            if ($telechargement->getUtilisateur() === $this) {
                $telechargement->setUtilisateur(null);
            }
        }

        return $this;
    }
}
