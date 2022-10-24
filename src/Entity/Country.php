<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


#[ORM\Column(nullable: true)]
    private ?string $name;
#[ORM\Column(nullable: true)]
    private ?string $code;
#[ORM\Column(nullable: true)]
    private ?string $flag;
    #[ORM\Column(nullable: true)]
    private ?string $currency;
#[ORM\Column(nullable: true)]
    private ?float $rate;
    #[ORM\Column(nullable: true)]
    private ?float $fixedcharged;
    #[ORM\Column(nullable: true)]
    private ?float $percentcharge;
    #[ORM\Column(nullable: true)]
    private ?float $status;
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

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @param string|null $currency
     */
    public function setCurrency(?string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return float|null
     */
    public function getRate(): ?float
    {
        return $this->rate;
    }

    /**
     * @param float|null $rate
     */
    public function setRate(?float $rate): void
    {
        $this->rate = $rate;
    }

    /**
     * @return float|null
     */
    public function getFixedcharged(): ?float
    {
        return $this->fixedcharged;
    }

    /**
     * @param float|null $fixedcharged
     */
    public function setFixedcharged(?float $fixedcharged): void
    {
        $this->fixedcharged = $fixedcharged;
    }

    /**
     * @return float|null
     */
    public function getPercentcharge(): ?float
    {
        return $this->percentcharge;
    }

    /**
     * @param float|null $percentcharge
     */
    public function setPercentcharge(?float $percentcharge): void
    {
        $this->percentcharge = $percentcharge;
    }

    /**
     * @return float|null
     */
    public function getStatus(): ?float
    {
        return $this->status;
    }

    /**
     * @param float|null $status
     */
    public function setStatus(?float $status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getFlag()
    {
        return $this->flag;
    }

    /**
     * @param mixed $flag
     */
    public function setFlag($flag): void
    {
        $this->flag = $flag;
    }

    public function __toString()
    {
        return $this->code . ': ' . $this->name;
    }

}
