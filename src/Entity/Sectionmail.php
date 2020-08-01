<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sectionmail
 *
 * @ORM\Table(name="sectionmail")
 * @ORM\Entity
 */
class Sectionmail
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
     * @var string
     *
     * @ORM\Column(name="user1name", type="string", length=255, nullable=false)
     */
    private $user1name;

    /**
     * @var string
     *
     * @ORM\Column(name="user2name", type="string", length=255, nullable=false)
     */
    private $user2name;

    /**
     * @var string
     *
     * @ORM\Column(name="user3mail", type="string", length=255, nullable=false)
     */
    private $user3mail;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255, nullable=false)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="sg1name", type="string", length=255, nullable=false)
     */
    private $sg1name;

    /**
     * @var string
     *
     * @ORM\Column(name="sg2name", type="string", length=255, nullable=false)
     */
    private $sg2name;

    /**
     * @var string
     *
     * @ORM\Column(name="sg3mail", type="string", length=255, nullable=false)
     */
    private $sg3mail;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_mail", type="datetime", nullable=false)
     */
    private $dateMail;

    /**
     * @var bool
     *
     * @ORM\Column(name="gender", type="boolean", nullable=false)
     */
    private $gender;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser1name(): ?string
    {
        return $this->user1name;
    }

    public function setUser1name(string $user1name): self
    {
        $this->user1name = $user1name;

        return $this;
    }

    public function getUser2name(): ?string
    {
        return $this->user2name;
    }

    public function setUser2name(string $user2name): self
    {
        $this->user2name = $user2name;

        return $this;
    }

    public function getUser3mail(): ?string
    {
        return $this->user3mail;
    }

    public function setUser3mail(string $user3mail): self
    {
        $this->user3mail = $user3mail;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getSg1name(): ?string
    {
        return $this->sg1name;
    }

    public function setSg1name(string $sg1name): self
    {
        $this->sg1name = $sg1name;

        return $this;
    }

    public function getSg2name(): ?string
    {
        return $this->sg2name;
    }

    public function setSg2name(string $sg2name): self
    {
        $this->sg2name = $sg2name;

        return $this;
    }

    public function getSg3mail(): ?string
    {
        return $this->sg3mail;
    }

    public function setSg3mail(string $sg3mail): self
    {
        $this->sg3mail = $sg3mail;

        return $this;
    }

    public function getDateMail(): ?\DateTimeInterface
    {
        return $this->dateMail;
    }

    public function setDateMail(\DateTimeInterface $dateMail): self
    {
        $this->dateMail = $dateMail;

        return $this;
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


}
