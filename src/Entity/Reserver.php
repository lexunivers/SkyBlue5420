<?php

namespace App\Entity;

use App\Repository\ReserverRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReserverRepository::class)
 */
class Reserver
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(name="resourceId", type="string", length=255)
     */
    private $resourceId;

    /**
     * @ORM\Column(name="reservataire", type="integer")
     */
    private $reservataire;


    /**
     * @ORM\Column(name="formateur", type="string", length=255)
     */
    private $formateur;

     /**
     * @ORM\Column(name="appareil", type="string", length=255)
     */
    private $appareil;   


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getResourceId(): ?string
    {
        return $this->resourceId;
    }

    public function setResourceId(string $resourceId): self
    {
        $this->resourceId = $resourceId;

        return $this;
    }

    public function DureeDuVol(){

        $dureeduvol = date_diff($this->end,$this->start);
        return $dureeduvol->format('%H:%I');

    }


public function getReservataire(): ?int
{
    return $this->reservataire;
}

public function setReservataire(int $reservataire): self
{
    $this->reservataire = $reservataire;

    return $this;
}


    /**
     *
     * @ORM\ManyToOne(targetEntity="Instructeur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="instructeur", referencedColumnName="id")
     * })
     */
    private $instructeur;	

    /**
    * @var \Avion
    * @ORM\ManyToOne(targetEntity="Avions")
    * @ORM\JoinColumns({
    *   @ORM\JoinColumn(name="Avion", referencedColumnName="id")
    * })
    */
    private $avion;

    public function getAvion(): ?Avions
    {
        return $this->avion;
    }
    
    public function setAvion(?Avions $avion): self
    {
        $this->avion = $avion;
    
        return $this;
    }
    
    public function getInstructeur(): ?Instructeur
    {
        return $this->instructeur;
    }

    public function setInstructeur(?Instructeur $instructeur): self
    {
        $this->instructeur = $instructeur;

        return $this;
    }

    public function getFormateur(): ?string
    {
        return $this->formateur;
    }

    public function setFormateur(string $formateur): self
    {
        $this->formateur = $formateur;

        return $this;
    }

    public function getAppareil(): ?string
    {
        return $this->appareil;
    }

    public function setAppareil(string $appareil): self
    {
        $this->appareil = $appareil;

        return $this;
    }







}
