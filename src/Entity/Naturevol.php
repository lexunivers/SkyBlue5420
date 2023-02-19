<?php

namespace App\Entity;

use App\Repository\NaturevolRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NaturevolRepository::class)
 */
class Naturevol
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
     * @ORM\Column(name="naturevol", type="string", length=255, nullable=false)
     */
    private $naturevol;


    public function getNaturevol(): ?string
    {
        return $this->naturevol;
    }

    public function setNaturevol(string $naturevol): self
    {
        $this->naturevol = $naturevol;

        return $this;
    }

    public function __toString()
    {
        return $this->naturevol;
    }	
}
