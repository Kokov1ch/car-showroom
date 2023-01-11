<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $availability;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $modelName;

    /**
     * @ORM\ManyToOne(targetEntity=Manufactor::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $manufactor;

    /**
     * @ORM\ManyToOne(targetEntity=Brand::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $brand;

    /**
     * @ORM\ManyToOne(targetEntity=TechnicalData::class, inversedBy="products")
     */
    private $technicalData;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isAvailability(): ?bool
    {
        return $this->availability;
    }

    public function setAvailability(bool $availability): self
    {
        $this->availability = $availability;

        return $this;
    }

    public function getModelName(): ?string
    {
        return $this->modelName;
    }

    public function setModelName(string $modelName): self
    {
        $this->modelName = $modelName;

        return $this;
    }

    public function getManufactor(): ?Manufactor
    {
        return $this->manufactor;
    }

    public function setManufactor(?Manufactor $manufactor): self
    {
        $this->manufactor = $manufactor;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getTechnicalData(): ?TechnicalData
    {
        return $this->technicalData;
    }

    public function setTechnicalData(?TechnicalData $technicalData): self
    {
        $this->technicalData = $technicalData;

        return $this;
    }
}
