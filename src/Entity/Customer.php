<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer
{
    public const BANNED="BANNED";
    public const ACTIVE="ACTIVE";
    public const PENDING="PENDING";
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

   #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $compte;
    #[ORM\Column(nullable: true)]
    private ?\DateTime $datecreation;
    #[ORM\Column(nullable: true)]
    private ?string $country;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;
    #[ORM\Column(nullable: true)]
    private ?bool $kycverify;
    #[ORM\Column(nullable: true)]
    private ?bool $emailverify;
    #[ORM\Column(nullable: true)]
    private ?bool $phoneverify;
    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompte(): ?User
    {
        return $this->compte;
    }

    public function setCompte(?User $compte): self
    {
        $this->compte = $compte;

        return $this;
    }

    public function getDatecreation(): ?\DateTimeInterface
    {
        return $this->datecreation;
    }

    public function setDatecreation(?\DateTimeInterface $datecreation): self
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return bool|null
     */
    public function getKycverify(): ?bool
    {
        return $this->kycverify;
    }

    /**
     * @param bool|null $kycverify
     */
    public function setKycverify(?bool $kycverify): void
    {
        $this->kycverify = $kycverify;
    }

    /**
     * @return bool|null
     */
    public function getEmailverify(): ?bool
    {
        return $this->emailverify;
    }

    /**
     * @param bool|null $emailverify
     */
    public function setEmailverify(?bool $emailverify): void
    {
        $this->emailverify = $emailverify;
    }

    /**
     * @return bool|null
     */
    public function getPhoneverify(): ?bool
    {
        return $this->phoneverify;
    }

    /**
     * @param bool|null $phoneverify
     */
    public function setPhoneverify(?bool $phoneverify): void
    {
        $this->phoneverify = $phoneverify;
    }

}
