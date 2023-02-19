<?php

namespace App\Entity;

use App\Repository\InstructeurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InstructeurRepository::class)
 */
class Instructeur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=64, nullable=false)
     */
    private $nom;


    /**
     * @var string
     *
     * @ORM\Column(name="initiales", type="string", length=64, nullable=false)
     */
    private $initiales;
	

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }


    public function __toString()
    {
        return $this->getNom();//.' '.$this->getLastName();
    }

    public function getInitiales(): ?string
    {
        return $this->initiales;
    }

    public function setInitiales(string $initiales): self
    {
        $this->initiales = $initiales;

        return $this;
    }
}
