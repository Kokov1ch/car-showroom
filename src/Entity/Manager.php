<?php

namespace App\Entity;

use App\Repository\ManagerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ManagerRepository::class)
 */
class Manager
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
    private $managerFio;

    /**
     * @ORM\Column(type="float")
     */
    private $baseRate;

    /**
     * @ORM\OneToMany(targetEntity=Request::class, mappedBy="manager", cascade={"remove"})
     */
    private $requests;

    public function __construct()
    {
        $this->requests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getManagerFio(): ?string
    {
        return $this->managerFio;
    }

    public function setManagerFio(string $managerFio): self
    {
        $this->managerFio = $managerFio;

        return $this;
    }

    public function getBaseRate(): ?float
    {
        return $this->baseRate;
    }

    public function setBaseRate(float $baseRate): self
    {
        $this->baseRate = $baseRate;

        return $this;
    }

    /**
     * @return Collection<int, Request>
     */
    public function getRequests(): Collection
    {
        return $this->requests;
    }

    public function addRequest(Request $request): self
    {
        if (!$this->requests->contains($request)) {
            $this->requests[] = $request;
            $request->setManager($this);
        }

        return $this;
    }

    public function removeRequest(Request $request): self
    {
        if ($this->requests->removeElement($request)) {
            // set the owning side to null (unless already changed)
            if ($request->getManager() === $this) {
                $request->setManager(null);
            }
        }

        return $this;
    }
}
