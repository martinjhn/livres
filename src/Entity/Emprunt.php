<?php

namespace App\Entity;

use App\Repository\EmpruntRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmpruntRepository::class)
 */
class Emprunt
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Livre::class, inversedBy="emprunts")
     */
    private $livre;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="emprunts")
     */
    private $emprunteur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLivre(): ?Livre
    {
        return $this->livre;
    }

    public function setLivre(?Livre $livre): self
    {
        $this->livre = $livre;

        return $this;
    }

    public function getEmprunteur(): ?Utilisateur
    {
        return $this->emprunteur;
    }

    public function setEmprunteur(?Utilisateur $emprunteur): self
    {
        $this->emprunteur = $emprunteur;

        return $this;
    }
}
