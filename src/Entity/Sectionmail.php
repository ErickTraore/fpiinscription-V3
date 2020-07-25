<?php

namespace App\Entity;

use App\Repository\SectionmailRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SectionmailRepository::class)
 */
class Sectionmail
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user1name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user2name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user3mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sg1name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sg2name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sg3mail;
  
    /**
     * @ORM\Column(name="date_mail", type="datetime")
     * @Assert\Type("\DateTimeInterface")
     */
    private $dateMail;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $gender;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function construct()
    {
        $this->dateMail = new \DATETIME();
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
