<?php

namespace App\Entity;

use App\Repository\CpteIndividuelRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

//#[ORM\Entity(repositoryClass: CpteIndividuelRepository::class)]

/**
 * @ORM\Entity(repositoryClass=CpteIndividuelRepository::class)
 */
class CpteIndividuel
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
    * @var \User
    *
    * @ORM\ManyToOne(targetEntity="User")
    * @ORM\JoinColumns({
    *   @ORM\JoinColumn(name="User_id", referencedColumnName="id")
    * })
    */
    private $user;

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
