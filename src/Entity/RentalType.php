<?php

namespace App\Entity;

use App\Repository\RentalTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RentalTypeRepository::class)
 */
class RentalType
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
    private $label;

    /**
     * @ORM\Column(type="integer")
     */
    private $capacity;

    /**
     * @ORM\Column(type="float")
     */
    private $dailyPrice;

    /**
     * @ORM\OneToMany(targetEntity=Rentals::class, mappedBy="typeId")
     */
    private $rentals;

    public function __construct()
    {
        $this->rentals = new ArrayCollection();
    }

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

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getDailyPrice(): ?float
    {
        return $this->dailyPrice;
    }

    public function setDailyPrice(float $dailyPrice): self
    {
        $this->dailyPrice = $dailyPrice;

        return $this;
    }

    /**
     * @return Collection<int, Rentals>
     */
    public function getRentals(): Collection
    {
        return $this->rentals;
    }

    public function addRental(Rentals $rental): self
    {
        if (!$this->rentals->contains($rental)) {
            $this->rentals[] = $rental;
            $rental->setTypeId($this);
        }

        return $this;
    }

    public function removeRental(Rentals $rental): self
    {
        if ($this->rentals->removeElement($rental)) {
            // set the owning side to null (unless already changed)
            if ($rental->getTypeId() === $this) {
                $rental->setTypeId(null);
            }
        }

        return $this;
    }

    public function getLabelCapacity(): string
    {
        if($this->getLabel() !== 'space') {
            return $this->getLabel() . ' ' .$this->getCapacity() . ' person';
        }
        else {
            return $this->getLabel() . ' ' .$this->getCapacity() . ' m2'; 
        }
    }
}
