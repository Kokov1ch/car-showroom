<?php

namespace App\Entity;

use App\Repository\RequestStepRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RequestStepRepository::class)
 */
class RequestStep
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=RequestType::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $type_id;

    /**
     * @ORM\ManyToOne(targetEntity=Request::class, cascade={"remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $request_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTypeId(): ?RequestType
    {
        return $this->type_id;
    }

    public function setTypeId(?RequestType $type_id): self
    {
        $this->type_id = $type_id;

        return $this;
    }

    public function getRequestId(): ?Request
    {
        return $this->request_id;
    }

    public function setRequestId(?Request $request_id): self
    {
        $this->request_id = $request_id;

        return $this;
    }
}
