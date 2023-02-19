<?php

namespace App\Entity;

use App\Repository\TerrainRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TerrainRepository::class)
 */
class Terrain
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
     * @ORM\Column(name="indicatif", type="string", length=255, nullable=false)
     */
    private $indicatif;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=false)
     */
    private $ville;

    /**
     * @var integer
     *
     * @ORM\Column(name="dept", type="integer", nullable=false)
     */
    private $dept;

    /**
     * Set indicatif
     *
     * @param string $indicatif
     * @return Terrain
     */
    public function setIndicatif($indicatif)
    {
        $this->indicatif = $indicatif;
    
        return $this;
    }

    /**
     * Get indicatif
     *
     * @return string
     */
    public function getIndicatif()
    {
        return $this->indicatif;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return Terrain
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    
        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set dept
     *
     * @param integer $dept
     * @return Terrain
     */
    public function setDept($dept)
    {
        $this->dept = $dept;
    
        return $this;
    }

    /**
     * Get dept
     *
     * @return integer
     */
    public function getDept()
    {
        return $this->dept;
    }
    
    public function __toString()
    {
        return $this->indicatif.' - '.$this->ville.' - '.$this->dept;
    }
    
    public function getTerrain()
    {
        return $this->indicatif.' - '.$this->ville.' - '.$this->dept;
    }


}
