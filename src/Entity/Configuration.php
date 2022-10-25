<?php

namespace App\Entity;

use App\Repository\ConfigurationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConfigurationRepository::class)]
class Configuration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $currency = null;

    #[ORM\Column(length: 20)]
    private ?string $symbole = null;

    #[ORM\Column(nullable: true)]
    private ?float $fixedcommission = null;

    #[ORM\Column(nullable: true)]
    private ?float $percentcommision = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getSymbole(): ?string
    {
        return $this->symbole;
    }

    public function setSymbole(string $symbole): self
    {
        $this->symbole = $symbole;

        return $this;
    }

    public function getFixedcommission(): ?float
    {
        return $this->fixedcommission;
    }

    public function setFixedcommission(?float $fixedcommission): self
    {
        $this->fixedcommission = $fixedcommission;

        return $this;
    }

    public function getPercentcommision(): ?float
    {
        return $this->percentcommision;
    }

    public function setPercentcommision(?float $percentcommision): self
    {
        $this->percentcommision = $percentcommision;

        return $this;
    }
}
