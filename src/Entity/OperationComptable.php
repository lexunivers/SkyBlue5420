<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OperationComptableRepository")
 */
class OperationComptable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id;

    /**
    * @var \User
    *
    * @ORM\ManyToOne(targetEntity="User")
    * @ORM\JoinColumns({
    *   @ORM\JoinColumn(name="User_id", referencedColumnName="id")
    * })
    */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $CompteId;

    /**
     * @ORM\Column(type="datetime")
     */
    private $OperDate;

    /**
    * @ORM\Column(type="decimal", precision=12, scale=2)
    */
    private $OperMontant;

    
    /**
    * @ORM\Column(type="integer")
    */
    private $OperSensMt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Libelle;
    
    public function __construct()
    {
        $this->OperDate = new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompteId(): ?int
    {
        return $this->CompteId;
    }

    public function setCompteId(int $CompteId): self
    {
        $this->CompteId = $CompteId;

        return $this;
    }

    public function getOperDate(): ?\DateTimeInterface
    {
        return $this->OperDate;
    }

    public function setOperDate(\DateTimeInterface $OperDate): self
    {
        $this->OperDate = $OperDate;

        return $this;
    }



    public function getOperSensMt(): ?int
    {
        return $this->OperSensMt;
    }

    public function setOperSensMt(int $OperSensMt): self
    {
        $this->OperSensMt = $OperSensMt;

        return $this;
    }

    public function getOperMontant()
    {
        return $this->OperMontant;
    }

    public function setOperMontant($OperMontant): self
    {
        $this->OperMontant = $OperMontant;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->Libelle;
    }

    public function setLibelle(?string $Libelle): self
    {
        $this->Libelle = $Libelle;

        return $this;
    }

    public function getLibelleCotis()
    {
        return 	'Cotisation Club ';
    }
    
    public function getLibelleFFA()
    {
        return 	'Licence FFA ';
    }    

    public function getLibelleInfo()
    {
        return 	'Abonnement InfoPilote ';
    }    

    public function somme()
    {
        $somme += $this->getOperMontant();
    
        return $somme;
    }

//    public function TotalMontant()
//    {
//        if (is_array($OperMontant) || is_object($OperMontant)) {
//            foreach ($OperMontant() as $totalopermontant) {
//                $totalmontant += $totalopermontant;
//            }
//        }
//        return $totalmontant;
//    }

//    public function getTotalReglements()
//    {
//        $total = 0;
//        foreach ($this->getReglements() as $reglement) {
//            $total += $reglement->getMontantReglement();
//        }
//        return $total;
//    }

//    public function getTotalOperMontant()
//    {
//        $total = 0;
  
//        $OperMontant1 = $this->getOperMontant();

//        if (is_array($OperMontant1) || is_object($OperMontant)) {
//            foreach ($OperMontant1 as $facture) {
//                $total += $facture;
//            }
//        }
//        return $total;
//    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
