<?php

namespace App\Entity;

use App\Repository\ManufactorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ManufactorRepository::class)
 */
class Manufactor
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
    private $manufactorCountry;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $manufactorName;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="manufactor", orphanRemoval=true)
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

    public function getManufactorCounty(): ?string
    {
        return $this->manufactorCountry;
    }

    public function setManufactorCounty(string $manufactorCountry): self
    {
        $this->manufactorCountry = $manufactorCountry;

        return $this;
    }

    public function getManufactorName(): ?string
    {
        return $this->manufactorName;
    }

    public function setManufactorName(?string $manufactorName): self
    {
        $this->manufactorName = $manufactorName;

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
            $product->setManufactor($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getManufactor() === $this) {
                $product->setManufactor(null);
            }
        }

        return $this;
    }
}
