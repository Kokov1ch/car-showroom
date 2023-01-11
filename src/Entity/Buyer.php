<?php

namespace App\Entity;

use App\Repository\BuyerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BuyerRepository::class)
 */
class Buyer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $buyerFio;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $buyerPassportSeries;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $buyerPassportNumber;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBuyerFio(): ?string
    {
        return $this->buyerFio;
    }

    public function setBuyerFio(string $buyerFio): self
    {
        $this->buyerFio = $buyerFio;

        return $this;
    }

    public function getBuyerPassportSeries(): ?string
    {
        return $this->buyerPassportSeries;
    }

    public function setBuyerPassportSeries(string $buyerPassportSeries): self
    {
        $this->buyerPassportSeries = $buyerPassportSeries;

        return $this;
    }

    public function getBuyerPassportNumber(): ?string
    {
        return $this->buyerPassportNumber;
    }

    public function setBuyerPassportNumber(string $buyerPassportNumber): self
    {
        $this->buyerPassportNumber = $buyerPassportNumber;

        return $this;
    }
}
