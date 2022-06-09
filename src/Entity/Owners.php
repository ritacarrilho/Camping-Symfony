<?php

namespace App\Entity;

use App\Repository\OwnersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OwnersRepository::class)
 */
class Owners
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
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="integer")
     */
    private $contractNumber;

    /**
     * @ORM\Column(type="date")
     */
    private $endDate;

    /**
     * @ORM\OneToMany(targetEntity=Rentals::class, mappedBy="ownerId")
     */
    private $rental;

    public function __construct()
    {
        $this->rental = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getContractNumber(): ?int
    {
        return $this->contractNumber;
    }

    public function setContractNumber(int $contractNumber): self
    {
        $this->contractNumber = $contractNumber;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    // FullName format
    public function getFullName() {
        return $this->getFirstName(). " " . $this->getLastName();
    }

    public function getDateString(): string
    {
        return date_format($this->getEndDate(), "jS F Y");
    }

    /**
     * @return Collection<int, Rentals>
     */
    public function getRental(): Collection
    {
        return $this->rental;
    }

    public function addRental(Rentals $rental): self
    {
        if (!$this->rental->contains($rental)) {
            $this->rental[] = $rental;
            $rental->setOwnerId($this);
        }

        return $this;
    }

    public function removeRental(Rentals $rental): self
    {
        if ($this->rental->removeElement($rental)) {
            // set the owning side to null (unless already changed)
            if ($rental->getOwnerId() === $this) {
                $rental->setOwnerId(null);
            }
        }

        return $this;
    }
}
