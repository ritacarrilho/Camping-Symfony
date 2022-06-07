<?php

namespace App\Entity;

use App\Repository\RentalsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RentalsRepository::class)
 */
class Rentals
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $picture;

    /**
     * @ORM\ManyToOne(targetEntity=Owners::class, inversedBy="rentals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ownerId;

    /**
     * @ORM\ManyToOne(targetEntity=RentalType::class, inversedBy="rentals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeId;

    /**
     * @ORM\OneToMany(targetEntity=Reservations::class, mappedBy="rentalId")
     */
    private $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getReference(): ?int
    {
        return $this->reference;
    }

    public function setReference(int $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getOwnerId(): ?Owners
    {
        return $this->ownerId;
    }

    public function setOwnerId(?Owners $ownerId): self
    {
        $this->ownerId = $ownerId;

        return $this;
    }

    public function getTypeId(): ?RentalType
    {
        return $this->typeId;
    }

    public function setTypeId(?RentalType $typeId): self
    {
        $this->typeId = $typeId;

        return $this;
    }

    /**
     * @return Collection<int, Reservations>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservations $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setRentalId($this);
        }

        return $this;
    }

    public function removeReservation(Reservations $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getRentalId() === $this) {
                $reservation->setRentalId(null);
            }
        }

        return $this;
    }
}
