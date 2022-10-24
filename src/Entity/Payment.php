<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
class Payment
{
    public  const PAID='PAID';
    public  const REJECT='REJECT';
    public  const REFUNDED='REFUNDED';
    public  const PAYOUT='PAYOUT';
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $amount = null;
    #[ORM\Column(nullable: true)]
    private ?float $amountreceive = null;
    #[ORM\Column(nullable: true)]
    private ?float $rate = null;

    #[ORM\ManyToOne]
    private ?User $createdby = null;

    #[ORM\ManyToOne]
    private ?Sourcefunds $sourcefund = null;

    #[ORM\ManyToOne]
    private ?Sourcepurpose $sourcepurpose = null;

    #[ORM\ManyToOne]
    private ?Country $country = null;

    #[ORM\ManyToOne]
    private ?Country $countryfrom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reference = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\ManyToOne]
    private ?SenderReceiver $sender = null;

    #[ORM\ManyToOne]
    private ?SenderReceiver $receiver = null;
    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedby(): ?User
    {
        return $this->createdby;
    }

    public function setCreatedby(?User $createdby): self
    {
        $this->createdby = $createdby;

        return $this;
    }

    public function getSourcefund(): ?Sourcefunds
    {
        return $this->sourcefund;
    }

    public function setSourcefund(?Sourcefunds $sourcefund): self
    {
        $this->sourcefund = $sourcefund;

        return $this;
    }

    public function getSourcepurpose(): ?Sourcepurpose
    {
        return $this->sourcepurpose;
    }

    public function setSourcepurpose(?Sourcepurpose $sourcepurpose): self
    {
        $this->sourcepurpose = $sourcepurpose;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCountryfrom(): ?Country
    {
        return $this->countryfrom;
    }

    public function setCountryfrom(?Country $countryfrom): self
    {
        $this->countryfrom = $countryfrom;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

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
     * @return float|null
     */
    public function getAmountreceive(): ?float
    {
        return $this->amountreceive;
    }

    /**
     * @param float|null $amountreceive
     */
    public function setAmountreceive(?float $amountreceive): void
    {
        $this->amountreceive = $amountreceive;
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

    public function getSender(): ?SenderReceiver
    {
        return $this->sender;
    }

    public function setSender(?SenderReceiver $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getReceiver(): ?SenderReceiver
    {
        return $this->receiver;
    }

    public function setReceiver(?SenderReceiver $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }

}
