<?php

namespace App\Entity;

use App\Repository\RequestTypeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RequestTypeRepository::class)
 */
class RequestType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $request_name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRequestName(): ?string
    {
        return $this->request_name;
    }

    public function setRequestName(string $request_name): self
    {
        $this->request_name = $request_name;

        return $this;
    }
}
