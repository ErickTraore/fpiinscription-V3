<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fpicount
 *
 * @ORM\Table(name="fpicount", indexes={@ORM\Index(name="IDX_F3CE4B93A76ED395", columns={"user_id"}), @ORM\Index(name="IDX_F3CE4B93F68139D7", columns={"adhesion_id"})})
 * @ORM\Entity
 */
class Fpicount
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ref", type="string", length=255, nullable=true)
     */
    private $ref;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="p_un_ht", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $pUnHt;

    /**
     * @var int|null
     *
     * @ORM\Column(name="qte", type="integer", nullable=true)
     */
    private $qte;

    /**
     * @var string|null
     *
     * @ORM\Column(name="remise", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $remise;

    /**
     * @var string|null
     *
     * @ORM\Column(name="p_un_ht_rem", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $pUnHtRem;

    /**
     * @var string|null
     *
     * @ORM\Column(name="prix_tot_ht", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $prixTotHt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tva", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $tva;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_bill", type="datetime", nullable=true)
     */
    private $dateBill;

    /**
     * @var string|null
     *
     * @ORM\Column(name="total_ttc", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $totalTtc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tot_cumul", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $totCumul;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_cumul", type="datetime", nullable=true)
     */
    private $dateCumul;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_echeance", type="datetime", nullable=true)
     */
    private $dateEcheance;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var \Adhesion
     *
     * @ORM\ManyToOne(targetEntity="Adhesion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="adhesion_id", referencedColumnName="id")
     * })
     */
    private $adhesion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(?string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPUnHt(): ?string
    {
        return $this->pUnHt;
    }

    public function setPUnHt(?string $pUnHt): self
    {
        $this->pUnHt = $pUnHt;

        return $this;
    }

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(?int $qte): self
    {
        $this->qte = $qte;

        return $this;
    }

    public function getRemise(): ?string
    {
        return $this->remise;
    }

    public function setRemise(?string $remise): self
    {
        $this->remise = $remise;

        return $this;
    }

    public function getPUnHtRem(): ?string
    {
        return $this->pUnHtRem;
    }

    public function setPUnHtRem(?string $pUnHtRem): self
    {
        $this->pUnHtRem = $pUnHtRem;

        return $this;
    }

    public function getPrixTotHt(): ?string
    {
        return $this->prixTotHt;
    }

    public function setPrixTotHt(?string $prixTotHt): self
    {
        $this->prixTotHt = $prixTotHt;

        return $this;
    }

    public function getTva(): ?string
    {
        return $this->tva;
    }

    public function setTva(?string $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getDateBill(): ?\DateTimeInterface
    {
        return $this->dateBill;
    }

    public function setDateBill(?\DateTimeInterface $dateBill): self
    {
        $this->dateBill = $dateBill;

        return $this;
    }

    public function getTotalTtc(): ?string
    {
        return $this->totalTtc;
    }

    public function setTotalTtc(?string $totalTtc): self
    {
        $this->totalTtc = $totalTtc;

        return $this;
    }

    public function getTotCumul(): ?string
    {
        return $this->totCumul;
    }

    public function setTotCumul(?string $totCumul): self
    {
        $this->totCumul = $totCumul;

        return $this;
    }

    public function getDateCumul(): ?\DateTimeInterface
    {
        return $this->dateCumul;
    }

    public function setDateCumul(?\DateTimeInterface $dateCumul): self
    {
        $this->dateCumul = $dateCumul;

        return $this;
    }

    public function getDateEcheance(): ?\DateTimeInterface
    {
        return $this->dateEcheance;
    }

    public function setDateEcheance(?\DateTimeInterface $dateEcheance): self
    {
        $this->dateEcheance = $dateEcheance;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getAdhesion(): ?Adhesion
    {
        return $this->adhesion;
    }

    public function setAdhesion(?Adhesion $adhesion): self
    {
        $this->adhesion = $adhesion;

        return $this;
    }

     /**
    * toString
    * @return string
    */
    public function __toString(){
        return $this;
    }


}
