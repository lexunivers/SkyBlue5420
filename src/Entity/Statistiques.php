<?php

namespace App\Entity;

use App\Repository\StatistiquesRepository;
use Doctrine\ORM\Mapping as ORM;

//#[ORM\Entity(repositoryClass: StatistiquesRepository::class)]

/**
 * @ORM\Entity(repositoryClass=StatistiquesRepository::class)
 */
class Statistiques
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
}
