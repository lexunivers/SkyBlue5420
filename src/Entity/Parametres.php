<?php

namespace App\Entity;

use App\Repository\ParametresRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

//#[ORM\Entity(repositoryClass: ParametresRepository::class)]


/**
 * @ORM\Entity(repositoryClass=ParametresRepository::class)
 */
class Parametres
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    //#[ORM\Column(length: 255)]
    
	/**
     * @var string
     * @ORM\Column(name="cle", type="string", length=255, nullable=false)
     */

    private $cle;


//    #[ORM\Column(type: Types::TEXT)]
    
	/**
     * @var string
     * @ORM\Column(name="valeur", type="string", length=255, nullable=false)
     */
    private $valeur;

    //#[ORM\Column]
    
    /**
    * @ORM\Column(type="datetime")
    */  	
	private $update_at;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCle(): ?string
    {
        return $this->cle;
    }

    public function setCle(string $cle): self
    {
        $this->cle = $cle;

        return $this;
    }

    public function getValeur(): ?string
    {
        return $this->valeur;
    }

    public function setValeur(string $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getUpdateAt(): ?\DateTime
    {
        return $this->update_at;
    }

    public function setUpdateAt(\DateTime $update_at): self
    {
        $this->update_at = $update_at;

        return $this;
    }
}
