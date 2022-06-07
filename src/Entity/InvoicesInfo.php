<?php

namespace App\Entity;

use App\Repository\InvoicesInfoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InvoicesInfoRepository::class)
 */
class InvoicesInfo
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
    private $designation;

    /**
     * @ORM\Column(type="date")
     */
    private $emition_date;

    /**
     * @ORM\Column(type="float")
     */
    private $priceUnity;

    /**
     * @ORM\ManyToOne(targetEntity=Invoices::class, inversedBy="invoicesInfos")
     */
    private $invoiceId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getEmitionDate(): ?\DateTimeInterface
    {
        return $this->emition_date;
    }

    public function setEmitionDate(\DateTimeInterface $emition_date): self
    {
        $this->emition_date = $emition_date;

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

    public function getInvoiceId(): ?Invoices
    {
        return $this->invoiceId;
    }

    public function setInvoiceId(?Invoices $invoiceId): self
    {
        $this->invoiceId = $invoiceId;

        return $this;
    }
}
