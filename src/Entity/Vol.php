<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

//, uniqueConstraints={@ORM\UniqueConstraint(name="datevol", columns={"user_id", "avion_id"})}
  

/**
 * Vol
 *
 * @ORM\Table(name="vol")
 * @ORM\Entity(repositoryClass="App\Repository\VolRepository")
 * @UniqueEntity(fields={"datevol", "user", "heureDepart", "heureArrivee"  }, message="Cet vol est déjà enregistré") 
 * @ORM\Entity

 */
 
class Vol
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
    * @var \DateTime
    * @ORM\Column(name="datevol", type="date")
    */
    private $datevol;

    /**
    * @var \User
    * @ORM\ManyToOne(targetEntity="User")
    * @ORM\JoinColumns({
    *   @ORM\JoinColumn(name="User_id", referencedColumnName="id")
    * })
    */
    private $user;
     
    /**
    * @var \Avion
    * @ORM\ManyToOne(targetEntity="Avions")
    * @ORM\JoinColumns({
    *   @ORM\JoinColumn(name="Avion_id", referencedColumnName="id")
    * })
    */
    private $avion;
 
    /**
    * @ORM\ManyToOne(targetEntity="Typevol")
    * @ORM\JoinColumns({
    *   @ORM\JoinColumn(name="typevol_id", referencedColumnName="id")
    * })
    */
    private $typevol;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Naturevol")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="naturevol_id", referencedColumnName="id")
     * })
     */
    private $naturevol;
    

    /**
     * @var \Terrain
     *
     * @ORM\ManyToOne(targetEntity="Terrain")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="LieuDepart_id", referencedColumnName="id")
     * })
     */
    private $lieuDepart;

    /**
     * @var \Terrain
     *
     * @ORM\ManyToOne(targetEntity="Terrain")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="LieuArrivee_id", referencedColumnName="id")
     * })
     */
    private $lieuArrivee;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heureDepart", type="time")
     * //@Assert\heureDepart()
     */
    private $heureDepart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heureArrivee", type="time")
     * //@Assert\heureArrivee()
     */
    private $heureArrivee;

    /**
     * @var \Instructeur
     *
     * @ORM\ManyToOne(targetEntity="Instructeur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Instructeur_id", referencedColumnName="id")
     * })
     */
    private $instructeur;
    
    /**
    * @var \Comptable
    * @ORM\ManyToOne(targetEntity="OperationComptable", cascade={"persist", "remove"}))
    * @ORM\JoinColumns({
    *   @ORM\JoinColumn(name="Compte_id", referencedColumnName="id")
    * })
    */
    private $Comptable;
    
    /**
    * @var \facture
    * @ORM\Column(name="facture", type="string", length=255, nullable=true, )
    */
    private $facture;

    /**
    *
    * @ORM\Column(name="validation", type="boolean", nullable=true)
    */
    private $validation;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatevol(): ?\DateTimeInterface
    {
        return $this->datevol;
    }

    public function setDatevol(\DateTimeInterface $datevol): self
    {
        $this->datevol = $datevol;

        return $this;
    }

    public function getHeureDepart(): ?\DateTimeInterface
    {
        return $this->heureDepart;
    }

    public function setHeureDepart(\DateTimeInterface $heureDepart): self
    {
        $this->heureDepart = $heureDepart;

        return $this;
    }

    public function getHeureArrivee(): ?\DateTimeInterface
    {
        return $this->heureArrivee;
    }

    public function setHeureArrivee(\DateTimeInterface $heureArrivee): self
    {
        $this->heureArrivee = $heureArrivee;

        return $this;
    }

    /**
     * Get validation
     *
     * @return boolean
     */
    public function getValidation()
    {
        return $this->validation;
    }

    public function setValidation(?bool $validation): self
    {
        $this->validation = $validation;

        return $this;
    }

    public function getTypevol(): ?Typevol
    {
        return $this->typevol;
    }

    public function setTypevol(?Typevol $typevol): self
    {
        $this->typevol = $typevol;

        return $this;
    }

    public function getNaturevol(): ?Naturevol
    {
        return $this->naturevol;
    }

    public function setNaturevol(?Naturevol $naturevol): self
    {
        $this->naturevol = $naturevol;

        return $this;
    }

    public function getLieuDepart(): ?Terrain
    {
        return $this->lieuDepart;
    }

    public function setLieuDepart(?Terrain $lieuDepart): self
    {
        $this->lieuDepart = $lieuDepart;

        return $this;
    }

    public function getLieuArrivee(): ?Terrain
    {
        return $this->lieuArrivee;
    }

    public function setLieuArrivee(?Terrain $lieuArrivee): self
    {
        $this->lieuArrivee = $lieuArrivee;

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

    /**
    * @ORM\Column(name="dateOper", type="date")
     */
    private $dateOper;

    public function __construct()
    {
        $this->dateOper = new \DateTime('now');
    }

    public function getDateOper(): ?\DateTimeInterface
    {
        return $this->dateOper;
    }

    public function setDateOper(\DateTimeInterface $dateOper): self
    {
        $this->dateOper = $dateOper;

        return $this;
    }
    

    // ----- Affichage dans ConfigList selon qu'il s'agit d'un vol Solo, Ecole

    public function AffichageEcole()
    {
        if ($this->typevol == "Solo") {
            $affichageEcole = " n/a ";
        } elseif ($this->typevol =="Ecole") {
            $affichageEcole = $this->avion->getTarifInstruction();
        }
            
        return $affichageEcole;
    }
    
    public function AffichageInstructeur()
    {
        if ($this->typevol == "Solo") {
            $affichageInstructeur = " n/a ";
        } else {
            $affichageInstructeur = $this->instructeur;
        }
        return $affichageInstructeur;
    }


    // ----- function pour cumul des heures de fonctionnement du moteur
	
	public function add_heures($heure1,$heure2){
			
		$vol = new vol();
		$secondes1= $vol->heure_to_secondes($heure1);
		$secondes2= $vol->heure_to_secondes($heure2);
		$somme=$secondes1+$secondes2;
		//transfo en h:i:s
		$s=$somme % 60; //reste de la division en minutes => secondes
		$m1=($somme-$s) / 60; //minutes totales
		$m=$m1 % 60;//reste de la division en heures => minutes
		$h=($m1-$m) / 60; //heures
		$resultat=$h.":".$m.":".$s;
		return $resultat;
	}

    // ----- function lorsqu'un vol est supprimer on ajuste tmps fonctionnement du moteur
	public function diff_heures($heure1,$heure2){
			
		$vol = new vol();
		$secondes1= $vol->heure_to_secondes($heure1);
		$secondes2= $vol->heure_to_secondes($heure2);
		$diff=$secondes1-$secondes2;
		//transfo en h:i:s
		$s=$diff % 60; //reste de la division en minutes => secondes
		$m1=($diff-$s) / 60; //minutes totales
		$m=$m1 % 60;//reste de la division en heures => minutes
		$h=($m1-$m) / 60; //heures
		$resultat=$h.":".$m.":".$s;
		return $resultat;
	}

	public function heure_to_secondes($heure){
		$array_heure=explode(":",$heure);
		$secondes=3600*$array_heure[0]+60*$array_heure[1]+$array_heure[2];
		return $secondes;
	}


    public function HeuresdeF()
    {
        $HeuresdeF = $this->avion->getHeuresdevol();
        return $HeuresdeF;
    }

    public function HeuresdeFcellule()
    {
        $HeuresdeFcellule = $this->avion->getHeuresCellule();
        return $HeuresdeFcellule;
    }    
    
    // A - Elements à récupérer pour le calcul du montant à facturer au Pilote
    //------------------------------------------------------------------------

    // -1/- Détermination de la durée du Vol //
       
    public function DureeDuVol()
    {
        $dureeduvol = date_diff($this->heureDepart, $this->heureArrivee);
        return $dureeduvol->format('%H:%I:%S');
    }
      
    // -2/- Tarif Applicable selon le type de vol "Solo" ou "Ecole" //
    
    public function getTarifSolo()
    {
        $tarifsolo =  (int) (strval($this->avion->getTarifHoraire()));
            
        return $tarifsolo;
    }
    
    public function getTarifApplicable()
    {
        if ($this->typevol == "Solo") {
            $tarifapplicable = (int) (strval($this->avion->getTarifHoraire()));
        } else {
            $tarifapplicable =  (int) (strval($this->avion->getTarifHoraire() + $this->avion->getTarifInstruction()));
        }
            
        return $tarifapplicable;
    }
        
    // B -  Montant à facturer au Pilote
    //----------------------------------
    
    public function getMontantFacture()
    {
        
        //on récupére le Tarif Applicable au type de vol
        $tarif = $this->getTarifApplicable();
            
        // calcul du Coût du vol à facturer
        
			// 1 - On récupere le temps de vol
			$duree = $this->DureeDuVol('H:I');
			$tempsdeVol = strtotime($duree);
					
			// 2 - Extraction des heures et minutes
			$heure = idate('H', $tempsdeVol);
			$minutes = idate('i', $tempsdeVol);
					
			// 3 - convertion en minutes
			$HeureMinutes = ($heure*60);
			$TempsTotal = $HeureMinutes + $minutes ;

			// 4 - calcul du montant
			$montantfacture = (($tarif/60)* $TempsTotal);
			$montantfacture = round($montantfacture, 2);
        
        // Montant à porter au débit du Compte Pilote
     
        return $montantfacture;
    }

    // c - Affichage du "Libelle" dans OpérationComptable/ Montant
    //----------------------------------------------------------

    public function getLibelle()
    {
        return 	$this->datevol->format('d-m-Y ').' - '.'Vol de : '.$this->DureeDuVol('%h:%I').' h/min -'.$this->avion.' : ';
    }

    public function __toString(): string
    {
       // return $this->array('facture');
		  return $this->facture;
	}

    public function getFacture(): ?string
    {
        return $this->facture;
    }

    public function setFacture(?string $facture): self
    {
        $this->facture = $facture;

        return $this;
    }

    public function getComptable(): ?OperationComptable
    {
        return $this->Comptable;
    }

    public function setComptable(?OperationComptable $Comptable): self
    {
        $this->Comptable = $Comptable;

        return $this;
    }

    public function getAvion(): ?Avions
    {
        return $this->avion;
    }

    public function setAvion(?Avions $avion): self
    {
        $this->avion = $avion;

        return $this;
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

	
}
