<?php

namespace App\Entity;

use App\Repository\ServicesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServicesRepository::class)
 */
class Services
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $label;

    /**
     * @ORM\Column(type="integer")
     */
    private $perDay;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $consumerType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getPerDay(): ?float
    {
        $convert_euros = $this->perDay / 100;

        return $convert_euros;
    }

    public function setPerDay(int $perDay): self
    {
        $this->perDay = $perDay;

        return $this;
    }

    public function getConsumerType(): ?string
    {
        return $this->consumerType;
    }

    public function setConsumerType(string $consumerType): self
    {
        $this->consumerType = $consumerType;

        return $this;
    }
}
