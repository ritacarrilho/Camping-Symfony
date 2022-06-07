<?php

namespace App\Entity;

use App\Repository\InvoicesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InvoicesRepository::class)
 */
class Invoices
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $invoiceDate;

    /**
     * @ORM\Column(type="float")
     */
    private $priceUnity;

    /**
     * @ORM\Column(type="integer")
     */
    private $daysNumber;

    /**
     * @ORM\Column(type="integer")
     */
    private $invoiceReference;

    /**
     * @ORM\ManyToOne(targetEntity=Reservations::class, inversedBy="invoices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reservationId;

    /**
     * @ORM\OneToMany(targetEntity=InvoicesInfo::class, mappedBy="invoiceId")
     */
    private $invoicesInfos;

    public function __construct()
    {
        $this->invoicesInfos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvoiceDate(): ?\DateTimeInterface
    {
        return $this->invoiceDate;
    }

    public function setInvoiceDate(\DateTimeInterface $invoiceDate): self
    {
        $this->invoiceDate = $invoiceDate;

        return $this;
    }

    public function getPriceUnity(): ?float
    {
        return $this->priceUnity;
    }

    public function setPriceUnity(float $priceUnity): self
    {
        $this->priceUnity = $priceUnity;

        return $this;
    }

    public function getDaysNumber(): ?int
    {
        return $this->daysNumber;
    }

    public function setDaysNumber(int $daysNumber): self
    {
        $this->daysNumber = $daysNumber;

        return $this;
    }

    public function getInvoiceReference(): ?int
    {
        return $this->invoiceReference;
    }

    public function setInvoiceReference(int $invoiceReference): self
    {
        $this->invoiceReference = $invoiceReference;

        return $this;
    }

    public function getReservationId(): ?Reservations
    {
        return $this->reservationId;
    }

    public function setReservationId(?Reservations $reservationId): self
    {
        $this->reservationId = $reservationId;

        return $this;
    }

    /**
     * @return Collection<int, InvoicesInfo>
     */
    public function getInvoicesInfos(): Collection
    {
        return $this->invoicesInfos;
    }

    public function addInvoicesInfo(InvoicesInfo $invoicesInfo): self
    {
        if (!$this->invoicesInfos->contains($invoicesInfo)) {
            $this->invoicesInfos[] = $invoicesInfo;
            $invoicesInfo->setInvoiceId($this);
        }

        return $this;
    }

    public function removeInvoicesInfo(InvoicesInfo $invoicesInfo): self
    {
        if ($this->invoicesInfos->removeElement($invoicesInfo)) {
            // set the owning side to null (unless already changed)
            if ($invoicesInfo->getInvoiceId() === $this) {
                $invoicesInfo->setInvoiceId(null);
            }
        }

        return $this;
    }
}
