<?php

namespace App\Entity;

use App\Repository\AvionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AvionsRepository::class)
 */
class Avions
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
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="avion")
     */
    private $reservations;

    /**
     * @var string
     * @ORM\Column(name="immatriculation", type="string", length=64, nullable=false)
     */
    private $immatriculation;

    /**
     * @var string
     *
     * @ORM\Column(name="marque", type="string", length=64, nullable=false)
     */
    private $marque;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=64, nullable=false)
     */
    private $type;


    /**
     * @var string
     *
     * @ORM\Column(name="puissance", type="string", length=64, nullable=false)
     */
    private $puissance;

    /**
     * @var string
     *
     * @ORM\Column(name="AnneeModele", type="string", length=64, nullable=false)
     */
    private $anneemodele;

    /**
     * @var string
     *
     * @ORM\Column(name="AnneeAchat", type="string", length=64, nullable=false)
     */
    private $anneeachat;

    /**
     * @var string
     *
     * @ORM\Column(name="AnneeRevente", type="string", length=64, nullable=false)
     */
    private $anneerevente;

    /**
     * @var string
     *
     * @ORM\Column(name="essence", type="string", length=64, nullable=false)
     */
    private $essence;

    /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", length=5, nullable=false)
     */
    private $place;

    /**
     * @var integer
     *
     * @ORM\Column(name="Valeur", type="integer", nullable=false)
     */
    private $valeur;

    /**
     * @var \string
     *
     * @ORM\Column(name="HeuresdeVol", type="string")
     */
    private $heuresdevol;

    /**
     * @var string
     *
     * @ORM\Column(name="heuresCellule", type="string", nullable=true)
     */
    private $heuresCellule;

    /**
     * @var boolean
     *
     * @ORM\Column(name="EnParc", type="boolean", nullable=false)
     */
    private $enparc;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateFiche", type="date", nullable=false)
     */
    private $datefiche;
	
    /**
     * @var \string
     *
     * @ORM\Column(name="eventColor", type="string")
     */	
	private $eventColor;

    /**
     * @var integer
     * @ORM\Column(name="TarifHoraire", type="integer", nullable=false)
     */
    private $tarifHoraire;

    /**
     * @var integer
     *
     * @ORM\Column(name="Instruction", type="integer", nullable=false)
     */
    private $instruction;
	

    /**
    * @var \Avion
    * @ORM\OneToOne(targetEntity="Resources", cascade={"persist", "remove", "refresh"}))
    * @ORM\JoinColumns({
    *   @ORM\JoinColumn(name="ResourcesId", referencedColumnName="id", nullable=false)
    * })
    */
    private $Avion;

    /**
     * Set tarifHoraire
     *
     * @param integer $tarifHoraire
     * @return Avion
     */
    public function setTarifHoraire($tarifHoraire)
    {
        $this->tarifHoraire = $tarifHoraire;
    
        return $this;
    }

    /**
     * Get tarifHoraire
     *
     * @return integer
     */
    public function getTarifHoraire()
    {
        return $this->tarifHoraire;
    }

    /**
     * Set instruction
     *
     * @param integer $instruction
     * @return Avion
     */
    public function setInstruction($instruction)
    {
        $this->instruction = $instruction;
    
        return $this;
    }

    /**
     * Get instruction
     *
     * @return integer
     */
    public function getInstruction()
    {
        return $this->instruction;
    }


    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPuissance(): ?string
    {
        return $this->puissance;
    }

    public function setPuissance(string $puissance): self
    {
        $this->puissance = $puissance;

        return $this;
    }

    public function getAnneemodele(): ?string
    {
        return $this->anneemodele;
    }

    public function setAnneemodele(string $anneemodele): self
    {
        $this->anneemodele = $anneemodele;

        return $this;
    }

    public function getAnneeachat(): ?string
    {
        return $this->anneeachat;
    }

    public function setAnneeachat(string $anneeachat): self
    {
        $this->anneeachat = $anneeachat;

        return $this;
    }

    public function getAnneerevente(): ?string
    {
        return $this->anneerevente;
    }

    public function setAnneerevente(string $anneerevente): self
    {
        $this->anneerevente = $anneerevente;

        return $this;
    }

    public function getEssence(): ?string
    {
        return $this->essence;
    }

    public function setEssence(string $essence): self
    {
        $this->essence = $essence;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getValeur(): ?int
    {
        return $this->valeur;
    }

    public function setValeur(int $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getHeuresCellule(): ?string
    {
        return $this->heuresCellule;
    }

    public function setHeuresCellule(string $heuresCellule): self
    {
        $this->heuresCellule = $heuresCellule;

        return $this;
    }

    public function getEnparc(): ?bool
    {
        return $this->enparc;
    }

    public function setEnparc(bool $enparc): self
    {
        $this->enparc = $enparc;

        return $this;
    }

    public function getDatefiche(): ?\DateTimeInterface
    {
        return $this->datefiche;
    }

    public function setDatefiche(\DateTimeInterface $datefiche): self
    {
        $this->datefiche = $datefiche;

        return $this;
    }

    //----- Cette function est utilisée pour le champ Avion dans ConfigureFormFields de VolAdmin
    public function __toString()
    {
        return $this->type . "  " . $this->immatriculation;
//		return $this->ColorAvion;
    }

   
    //---- Cette function est utilisée dans AvionAdmin ConfigureFormList
    public function getAffichageAvions()
    {
        return $this->marque.' - '.$this->type.' - '.$this->immatriculation;
    }


    // ---- Données pour configureListFields(FormMapper VolAdmin) et public function "TarifApplicable" dans Vol.php --
    
    public function getTarifSolo()
    {
        return $this->tarifHoraire;
    }

    public function getTarifInstruction()
    {
        return $this->instruction;
    }

    public function getTarifEcole()
    {
        $tarifEcole = ($this->tarifHoraire + $this->instruction);
        
        return $tarifEcole;
    }

    public function getHeuresdevol(): ? string
    {
        return $this->heuresdevol;
    }

    public function setHeuresdevol( $heuresdevol): self
    {
        $this->heuresdevol = $heuresdevol;

        return $this;
    }



	public function getImmatriculation(): ?string
 	{
		return $this->immatriculation;
 	}

	public function setImmatriculation(string $immatriculation): self
 	{
		$this->immatriculation = $immatriculation;
                                                         
		return $this;
 	}

	public function getEventColor(): ?string
    {
		return $this->eventColor;
 	}

	public function setEventColor(string $eventColor): self
 	{
		$this->eventColor = $eventColor;
                                                         
		return $this;
 	}

//    public function getColorAvion(): ?Resources
//    {
//        return $this->ColorAvion;
//    }

//    public function setColorAvion(?Resources $ColorAvion): self
//    {
//        $this->ColorAvion = $ColorAvion;

//        return $this;
//    }

public function getAvion(): ?Resources
{
    return $this->Avion;
}

public function setAvion(Resources $Avion): self
{
    $this->Avion = $Avion;

    return $this;
}




}

