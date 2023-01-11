<?php

namespace App\Entity;

use App\Repository\TechnicalDataRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TechnicalDataRepository::class)
 */
class TechnicalData
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numberOfDoors;

    /**
     * @ORM\Column(type="integer")
     */
    private $numberOfSeats;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $engineType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $engineLocation;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="float")
     */
    private $engineVolume;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="technicalData")
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberOfDoors(): ?int
    {
        return $this->numberOfDoors;
    }

    public function setNumberOfDoors(int $numberOfDoors): self
    {
        $this->numberOfDoors = $numberOfDoors;

        return $this;
    }

    public function getNumberOfSeats(): ?int
    {
        return $this->numberOfSeats;
    }

    public function setNumberOfSeats(int $numberOfSeats): self
    {
        $this->numberOfSeats = $numberOfSeats;

        return $this;
    }

    public function getEngineType(): ?string
    {
        return $this->engineType;
    }

    public function setEngineType(string $engineType): self
    {
        $this->engineType = $engineType;

        return $this;
    }

    public function getEngineLocation(): ?string
    {
        return $this->engineLocation;
    }

    public function setEngineLocation(string $engineLocation): self
    {
        $this->engineLocation = $engineLocation;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getEngineVolume(): ?float
    {
        return $this->engineVolume;
    }

    public function setEngineVolume(float $engineVolume): self
    {
        $this->engineVolume = $engineVolume;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setTechnicalData($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getTechnicalData() === $this) {
                $product->setTechnicalData(null);
            }
        }

        return $this;
    }
}
