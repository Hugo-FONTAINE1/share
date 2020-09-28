<?php

namespace App\Entity;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Repository\TelechargementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TelechargementRepository::class)
 */
class Telechargement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb;

    /**
     * @ORM\ManyToOne(targetEntity=Fichier::class, inversedBy="telechargements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Fichier;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="telechargements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Utilisateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNb(): ?int
    {
        return $this->nb;
    }

    public function setNb(int $nb): self
    {
        $this->nb = $nb;

        return $this;
    }

    public function getFichier(): ?Fichier
    {
        return $this->Fichier;
    }

    public function setFichier(?Fichier $Fichier): self
    {
        $this->Fichier = $Fichier;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->Utilisateur;
    }

    public function setUtilisateur(?Utilisateur $Utilisateur): self
    {
        $this->Utilisateur = $Utilisateur;

        return $this;
    }
}
