<?php

namespace App\Entity;

use App\Repository\GatewayMethodRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GatewayMethodRepository::class)]
class GatewayMethod
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $currency = null;

    #[ORM\Column(nullable: true)]
    private ?float $rate = null;

    #[ORM\Column(nullable: true)]
    private ?float $minamount = null;

    #[ORM\Column(nullable: true)]
    private ?float $maxamount = null;

    #[ORM\Column(nullable: true)]
    private ?float $percentcharge = null;

    #[ORM\Column(nullable: true)]
    private ?float $fixedcharge = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $instruction = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(?float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getMinamount(): ?float
    {
        return $this->minamount;
    }

    public function setMinamount(?float $minamount): self
    {
        $this->minamount = $minamount;

        return $this;
    }

    public function getMaxamount(): ?float
    {
        return $this->maxamount;
    }

    public function setMaxamount(?float $maxamount): self
    {
        $this->maxamount = $maxamount;

        return $this;
    }

    public function getPercentcharge(): ?float
    {
        return $this->percentcharge;
    }

    public function setPercentcharge(?float $percentcharge): self
    {
        $this->percentcharge = $percentcharge;

        return $this;
    }

    public function getFixedcharge(): ?float
    {
        return $this->fixedcharge;
    }

    public function setFixedcharge(?float $fixedcharge): self
    {
        $this->fixedcharge = $fixedcharge;

        return $this;
    }

    public function getInstruction(): ?string
    {
        return $this->instruction;
    }

    public function setInstruction(?string $instruction): self
    {
        $this->instruction = $instruction;

        return $this;
    }
}
