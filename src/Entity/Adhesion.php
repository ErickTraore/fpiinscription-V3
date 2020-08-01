<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adhesion
 *
 * @ORM\Table(name="adhesion", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_C50CA65A3DA5256D", columns={"image_id"})})
 * @ORM\Entity
 */
class Adhesion
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
     * @var bool
     *
     * @ORM\Column(name="gender", type="boolean", nullable=false)
     */
    private $gender;

    /**
     * @var string|null
     *
     * @ORM\Column(name="statut", type="string", length=255, nullable=true)
     */
    private $statut;

    /**
     * @var string|null
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lieu_naissance", type="string", length=255, nullable=true)
     */
    private $lieuNaissance;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nationnalite", type="string", length=255, nullable=true)
     */
    private $nationnalite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nature_identite", type="string", length=255, nullable=true)
     */
    private $natureIdentite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="number_identity", type="string", length=255, nullable=true)
     */
    private $numberIdentity;

    /**
     * @var string|null
     *
     * @ORM\Column(name="voie", type="string", length=255, nullable=true)
     */
    private $voie;

    /**
     * @var string|null
     *
     * @ORM\Column(name="novoie", type="string", length=255, nullable=true)
     */
    private $novoie;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nomvoie", type="string", length=255, nullable=true)
     */
    private $nomvoie;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @var string|null
     *
     * @ORM\Column(name="pays", type="string", length=255, nullable=true)
     */
    private $pays;

    /**
     * @var string|null
     *
     * @ORM\Column(name="codepostale", type="string", length=5, nullable=true)
     */
    private $codepostale;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="profession", type="string", length=255, nullable=true)
     */
    private $profession;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="birthday", type="date", nullable=true)
     */
    private $birthday;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dateadhesion", type="datetime", nullable=true)
     */
    private $dateadhesion;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dateecheancebis", type="datetime", nullable=true)
     */
    private $dateecheancebis;

    /**
     * @var \Image
     *
     * @ORM\ManyToOne(targetEntity="Image")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     * })
     */
    private $image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGender(): ?bool
    {
        return $this->gender;
    }

    public function setGender(bool $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getLieuNaissance(): ?string
    {
        return $this->lieuNaissance;
    }

    public function setLieuNaissance(?string $lieuNaissance): self
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }

    public function getNationnalite(): ?string
    {
        return $this->nationnalite;
    }

    public function setNationnalite(?string $nationnalite): self
    {
        $this->nationnalite = $nationnalite;

        return $this;
    }

    public function getNatureIdentite(): ?string
    {
        return $this->natureIdentite;
    }

    public function setNatureIdentite(?string $natureIdentite): self
    {
        $this->natureIdentite = $natureIdentite;

        return $this;
    }

    public function getNumberIdentity(): ?string
    {
        return $this->numberIdentity;
    }

    public function setNumberIdentity(?string $numberIdentity): self
    {
        $this->numberIdentity = $numberIdentity;

        return $this;
    }

    public function getVoie(): ?string
    {
        return $this->voie;
    }

    public function setVoie(?string $voie): self
    {
        $this->voie = $voie;

        return $this;
    }

    public function getNovoie(): ?string
    {
        return $this->novoie;
    }

    public function setNovoie(?string $novoie): self
    {
        $this->novoie = $novoie;

        return $this;
    }

    public function getNomvoie(): ?string
    {
        return $this->nomvoie;
    }

    public function setNomvoie(?string $nomvoie): self
    {
        $this->nomvoie = $nomvoie;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getCodepostale(): ?string
    {
        return $this->codepostale;
    }

    public function setCodepostale(?string $codepostale): self
    {
        $this->codepostale = $codepostale;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(?string $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getDateadhesion(): ?\DateTimeInterface
    {
        return $this->dateadhesion;
    }

    public function setDateadhesion(?\DateTimeInterface $dateadhesion): self
    {
        $this->dateadhesion = $dateadhesion;

        return $this;
    }

    public function getDateecheancebis(): ?\DateTimeInterface
    {
        return $this->dateecheancebis;
    }

    public function setDateecheancebis(?\DateTimeInterface $dateecheancebis): self
    {
        $this->dateecheancebis = $dateecheancebis;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }


}
