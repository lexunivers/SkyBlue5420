<?php

namespace App\Entity;

use App\Repository\MaCotisationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MaCotisationRepository::class)
 */
class MaCotisation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)//, inversedBy="maCotisations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


    /**
     * @ORM\ManyToOne(targetEntity=CotisationClub::class)//, inversedBy="maCotisations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $statut;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cotisation;

    /**
     * @ORM\Column(type="integer", nullable=true))
     */
    private $LicenceFFA;

    /**
     * @ORM\Column(type="integer", nullable=true))
     */
    private $InfoPilote;

    /**
     * @var \Date
     * @ORM\Column(type="date", nullable=true))
     */
    private $annee;

    /**
    * @var \Comptable
    * @ORM\ManyToOne(targetEntity="OperationComptable", cascade={"persist", "remove"}))
    * @ORM\JoinColumns({
    *   @ORM\JoinColumn(name="Compte_id", referencedColumnName="id")
    * })
    */
    private $Comptable;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getStatut(): ?CotisationClub
    {
        return $this->statut;
    }

    public function setStatut(?CotisationClub $statut): self
    {
        $this->statut = $statut;
        return $this;
    }


    public function getCotisation(): ?int
    {
        return $this->cotisation = (int) (strval($this->statut->getMontantClub()));
    }

    public function setCotisation(int $cotisation): self
    {
		$this->cotisation = $cotisation;
        return $this;
    }

    public function getLicenceFFA(): ?int
    {
        return $this->LicenceFFA = (int) (strval($this->statut->getLicenceFFA()));
    }

    public function setLicenceFFA( $LicenceFFA): self
    {
        $this->LicenceFFA = $LicenceFFA ;
        return $this;
    }

    public function getInfoPilote(): ?int
    {
        return $this->InfoPilote;
    }

    public function setInfoPilote(int $InfoPilote): self
    {
        $this->InfoPilote = $InfoPilote;
        return $this;
    }


    public function TarifInfoPilote()
    {
        if ($this->InfoPilote == false) {
            $TarifInfoPilote = 0;
        } elseif ($this->InfoPilote == true) {
            $TarifInfoPilote = (int) (strval($this->statut->getInfoPilote()));
        }
        return $TarifInfoPilote;
    }

    public function getTotalCotisation()
    {
        $TotalCotisation =  (int) (strval($this->statut->getMontantClub() + $this->statut->getLicenceFFA() + $this->TarifInfoPilote() ) );
        return $TotalCotisation;
    }
   
    public function getLibelleCotis()
    {
        return 'Cotisation Club / Licence FFA -'.' / Année : '.$this->annee->format('Y ');//.' - ';
    }

//    public function getAnnee(): ?\DateTimeInterface
//    {
//        return $this->annee = $this->statut->getAnnee();
//    }

//    public function setAnnee(?\DateTimeInterface $annee): self
//    {
//        $this->annee = $annee;

//        return $this;
//    }

    public function getComptable(): ?OperationComptable
    {
        return $this->Comptable;
    }

    public function setComptable(?OperationComptable $Comptable): self
    {
        $this->Comptable = $Comptable;

        return $this;
    }

//    public function getAnnee(): ?\DateTimeInterface
//    {
//        return $this->annee = $this->statut->getAnnee();;
//    }

//    public function setAnnee(?\DateTimeInterface $annee): self
//    {
//        $this->annee = $annee;

//        return $this;
//    }

public function getAnnee(): ?\DateTimeInterface
{
    return $this->annee = $this->statut->getAnnee();
}

public function setAnnee(?\DateTimeInterface $annee): self
{
    $this->annee = $annee;

    return $this;
}

}
