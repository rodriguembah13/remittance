<?php

namespace App\Entity;

use App\Repository\DepositRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: DepositRepository::class)]
class Deposit
{


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $charge = null;

    #[ORM\Column(nullable: true)]
    private ?float $amount = null;

    #[ORM\Column(nullable: true)]
    private ?float $payable = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;
    #[ORM\ManyToOne]
    private ?User $createdby = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reference = null;
    #[ORM\Column(nullable: true)]
    private ?float $rate = null;
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCharge(): ?float
    {
        return $this->charge;
    }

    public function setCharge(?float $charge): self
    {
        $this->charge = $charge;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getPayable(): ?float
    {
        return $this->payable;
    }

    public function setPayable(?float $payable): self
    {
        $this->payable = $payable;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getCreatedby(): ?User
    {
        return $this->createdby;
    }

    /**
     * @param User|null $createdby
     */
    public function setCreatedby(?User $createdby): void
    {
        $this->createdby = $createdby;
    }

    /**
     * @return string|null
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * @param string|null $reference
     */
    public function setReference(?string $reference): void
    {
        $this->reference = $reference;
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
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface|null $createdAt
     */
    public function setCreatedAt(?DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

}
