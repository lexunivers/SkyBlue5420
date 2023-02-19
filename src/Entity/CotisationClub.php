<?php

namespace App\Entity;

use App\Repository\CotisationClubRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Entity(repositoryClass=CotisationClubRepository::class)
 */
class CotisationClub
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
    * @var \DateTime
    * @ORM\Column(name="annee", type="date")
    */
    private $annee;

    /**
    * @var \String
    * @ORM\Column(name="statut", type="string")
    */
    private $statut;
	
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Montantclub;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $LicenceFFA;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $InfoPilote;

    /**
    *
	* @ORM\Column(name="validation", type="boolean", nullable=true)
    */
    private $validation;




    public function getId(): ?int
    {
        return $this->id;
    }


    public function getLicenceFFA(): ?int
    {
        return $this->LicenceFFA;
    }

    public function setLicenceFFA(?int $LicenceFFA): self
    {
        $this->LicenceFFA = $LicenceFFA;

        return $this;
    }

    public function getInfoPilote(): ?int
    {
        return $this->InfoPilote;
    }

    public function setInfoPilote(?int $InfoPilote): self
    {
        $this->InfoPilote = $InfoPilote;

        return $this;
    }

    public function getAnnee(): ?\DateTimeInterface
    {
        return $this->annee;
    }

    public function setAnnee(\DateTimeInterface $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function __toString()
    {
        return $this->statut;
    }

    public function getMontantclub(): ?int
    {
        return $this->Montantclub;
    }

    public function setMontantclub(?int $Montantclub): self
    {
        $this->Montantclub = $Montantclub;

        return $this;
    }

    public function getValidation(): ?bool
    {
        return $this->validation;
    }

    public function setValidation(?bool $validation): self
    {
        $this->validation = $validation;

        return $this;
    }
	
}
