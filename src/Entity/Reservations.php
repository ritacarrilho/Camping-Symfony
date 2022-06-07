<?php

namespace App\Entity;

use App\Repository\ReservationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationsRepository::class)
 */
class Reservations
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
    private $clientName;

    /**
     * @ORM\Column(type="date")
     */
    private $checkin;

    /**
     * @ORM\Column(type="date")
     */
    private $checkout;

    /**
     * @ORM\Column(type="integer")
     */
    private $adultsNbr;

    /**
     * @ORM\Column(type="integer")
     */
    private $kidsNbr;

    /**
     * @ORM\Column(type="integer")
     */
    private $kidsPool;

    /**
     * @ORM\Column(type="integer")
     */
    private $adultsPool;

    /**
     * @ORM\Column(type="boolean")
     */
    private $yearSave;

    /**
     * @ORM\ManyToOne(targetEntity=Rentals::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rentalId;

    /**
     * @ORM\OneToMany(targetEntity=Invoices::class, mappedBy="reservationId")
     */
    private $invoices;

    public function __construct()
    {
        $this->invoices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    public function setClientName(string $clientName): self
    {
        $this->clientName = $clientName;

        return $this;
    }

    public function getCheckin(): ?\DateTimeInterface
    {
        return $this->checkin;
    }

    public function setCheckin(\DateTimeInterface $checkin): self
    {
        $this->checkin = $checkin;

        return $this;
    }

    public function getCheckout(): ?\DateTimeInterface
    {
        return $this->checkout;
    }

    public function setCheckout(\DateTimeInterface $checkout): self
    {
        $this->checkout = $checkout;

        return $this;
    }

    public function getAdultsNbr(): ?int
    {
        return $this->adultsNbr;
    }

    public function setAdultsNbr(int $adultsNbr): self
    {
        $this->adultsNbr = $adultsNbr;

        return $this;
    }

    public function getKidsNbr(): ?int
    {
        return $this->kidsNbr;
    }

    public function setKidsNbr(int $kidsNbr): self
    {
        $this->kidsNbr = $kidsNbr;

        return $this;
    }

    public function getKidsPool(): ?int
    {
        return $this->kidsPool;
    }

    public function setKidsPool(int $kidsPool): self
    {
        $this->kidsPool = $kidsPool;

        return $this;
    }

    public function getAdultsPool(): ?int
    {
        return $this->adultsPool;
    }

    public function setAdultsPool(int $adultsPool): self
    {
        $this->adultsPool = $adultsPool;

        return $this;
    }

    public function isYearSave(): ?bool
    {
        return $this->yearSave;
    }

    public function setYearSave(bool $yearSave): self
    {
        $this->yearSave = $yearSave;

        return $this;
    }

    public function getRentalId(): ?Rentals
    {
        return $this->rentalId;
    }

    public function setRentalId(?Rentals $rentalId): self
    {
        $this->rentalId = $rentalId;

        return $this;
    }

    /**
     * @return Collection<int, Invoices>
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoice(Invoices $invoice): self
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices[] = $invoice;
            $invoice->setReservationId($this);
        }

        return $this;
    }

    public function removeInvoice(Invoices $invoice): self
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getReservationId() === $this) {
                $invoice->setReservationId(null);
            }
        }

        return $this;
    }
}
