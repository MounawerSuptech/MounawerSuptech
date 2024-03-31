<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleRepository::class)]
class Module
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomModule = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $NbHeure = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomModule(): ?string
    {
        return $this->nomModule;
    }

    public function setNomModule(string $nomModule): static
    {
        $this->nomModule = $nomModule;

        return $this;
    }

    public function getNbHeure(): ?int
    {
        return $this->NbHeure;
    }

    public function setNbHeure(int $NbHeure): static
    {
        $this->NbHeure = $NbHeure;

        return $this;
    }
}
