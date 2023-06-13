<?php

namespace App\Entity;

use App\Repository\TurnRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TurnRepository::class)]
class Turn
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
